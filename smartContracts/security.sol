//SPDX-License-Identifier: MIT 
pragma solidity ^0.8.9;

import "./utility.sol";
import "./ERC1066.sol";
import "@openzeppelin/contracts/metatx/MinimalForwarder.sol";
import "@openzeppelin/contracts-upgradeable/proxy/utils/Initializable.sol";
import "@openzeppelin/contracts-upgradeable/proxy/utils/UUPSUpgradeable.sol";


//Proxy = 0xda0b56f91972010dCEf9041D18B6f4a3e4c88FB1
//Security = 0x1a9bf5BC09d9e288611aaEA866cdCa3b26369148
/// @custom:security-contact soporte@comunyt.com
abstract contract SecurityBase is Initializable, UUPSUpgradeable, ERC1066, Utility {

    /////////////////////////////// Extension ERC1462 for compliance ////////////////////////////////////////////
    struct Document {
        uint256 timeStamp;
        bytes32 name;
        bytes32 contentHash;
        string uri;
    }
    address internal trustedForwarder;
    mapping (bytes32 => Document) public documents;
    mapping (address => uint256) public whiteList;
    uint256 public maxMint;
    bytes32 public constant WHITELISTER_ROLE = keccak256("WHITELISTER_ROLE");
    bytes32 public constant EXCHANGE_ROLE = keccak256("EXCHANGE_ROLE");
    bytes32[] public documentNames;

}

contract Security is SecurityBase {

    event DecumentAdded(bytes32 indexed _name, bytes32 _contentHash, uint256 _timeStamp);
    event Whitelisted(address indexed _addr,address _who, uint256 _amount, uint256 _timeStamp);
    event MaxMintSet(uint256 maxMint);
    event TrustedForwarderChanged(address newTrustedForwarder, address whoChanged, uint256 _timeStamp);

    constructor() payable {
        _disableInitializers();
    }

    function initialize(address _exchange, address _trustedForwarder, string memory _name, string memory _symbol, uint256 _supply, string memory _IPFS, string memory _contentHash) initializer public {
        require(_trustedForwarder!=address(0x0),"trustedForwarder can't be null");
        UtilityOverride._Utility_initialize(_name, _symbol);
        uint256 _ScaledSuply = _supply * 10 ** decimals();
        emit MaxMintSet(_ScaledSuply); // Agregar la emisión del evento correspondiente
        _mint(_msgSender(), _ScaledSuply);
        maxMint = _ScaledSuply;
        _grantRole(WHITELISTER_ROLE, _msgSender());
        _grantRole(EXCHANGE_ROLE, _msgSender());
        trustedForwarder = _trustedForwarder;
        emit TrustedForwarderChanged(_trustedForwarder, _msgSender(), block.timestamp);
        exchange = Exchange(_exchange);
        emit ChangeExchange(_exchange,_msgSender(),block.timestamp);
        bytes32 _nameBytes32 = stringToBytes32(_name);
        bytes32 _contentHashBytes32 = stringToBytes32(_contentHash);
        attachDocument(_nameBytes32, _IPFS, _contentHashBytes32);
    }

    function stringToBytes32(string memory _string) internal pure returns (bytes32) {
        bytes32 _result;
        assembly {
            _result := mload(add(_string, 32))
        }
        return _result;
    }


    function isTrustedForwarder(address forwarder) public view virtual returns (bool) {
        return forwarder == trustedForwarder;
    }

    function _msgSender() internal view virtual override returns (address sender) {
        if (isTrustedForwarder(msg.sender) && msg.data.length >= 20) {
            // The assembly code is more direct than the Solidity version using `abi.decode`.
            /// @solidity memory-safe-assembly
            assembly {
                sender := shr(96, calldataload(sub(calldatasize(), 20)))
            }
        } else {
            return super._msgSender();
        }
    }

    function _msgData() internal view virtual override returns (bytes calldata) {
        if (isTrustedForwarder(msg.sender) && msg.data.length >= 20) {
            return msg.data[:msg.data.length - 20];
        } else {
            return super._msgData();
        }
    }
    
    function whiteListSelf(address _person, uint256 _amount) external virtual whenNotPaused returns (uint256 max) { //63000 gas
        require(_msgSender()==_person,"Not your account");
        require(whiteList[_person]==0,"you are whitelisted");
        address _link=exchange.link(_person);
        require(_link!=address(0x0),"Not a user");
        whiteList[_person] = _amount;
        emit Whitelisted(_person,_person, _amount, block.timestamp);
        return _amount;
    }

    function whiteListOne(address _person, uint256 _amount) external virtual whenNotPaused onlyRole(WHITELISTER_ROLE) returns (uint256 max) {
        address _link=exchange.link(_person);
        require(_link!=address(0x0),"Not a user");
        whiteList[_person] = _amount;
        emit Whitelisted(_person,_msgSender(), _amount, block.timestamp);
        return _amount;
    }

    function whiteListBach(address[] calldata _people, uint256 _amount) external virtual whenNotPaused onlyRole(WHITELISTER_ROLE) returns (uint256 max) {
        address[] memory _link;
        _link = exchange.linkBach(_people);
        uint256 _size = _people.length;
        uint256 _time = block.timestamp;
        address _addr;
        while(_size != 0) {
            unchecked {
                _size--;
            }
            _addr = _people[_size];
            if( _link[_size] != address(0x0) ) {
                whiteList[_addr] = _amount;
                emit Whitelisted(_addr,_msgSender(), _amount, _time);
            }
        }
        return _amount;
    }
    

    function attachDocument(bytes32 _name, string memory _uri, bytes32 _contentHash) public onlyRole(DEFAULT_ADMIN_ROLE){
        require(_name.length != 0, "name must not be empty");
        require(_contentHash.length != 0, "Missing hash, SHA-1 recomended");
        require(bytes(_uri).length != 0, "external URI must not be empty");
        require(documents[_name].timeStamp == 0, "Name already exists");
        uint256 _time = block.timestamp;
        documents[_name] = Document(_time, _name, _contentHash, _uri);
        documentNames.push(_name);
        emit DecumentAdded(_name, _contentHash, _time);
    }
   
    function lookupDocument(bytes32 _name) external view returns (string memory, bytes32) {
        Document storage _doc = documents[_name];
        return (_doc.uri, _doc.contentHash);
    }


    function transfer(address _to, uint256 _value) public virtual  override returns (bool) {
        require(checkTransferAllowed(_msgSender(), _to, _value) == STATUS_ALLOWED, "transfer not allowed");
        return ERC20Upgradeable.transfer(_to, _value);
    }

    function approve(address _spender, uint256 _amount) public virtual override whenNotPaused returns (bool) {
        return ERC20Upgradeable.approve(_spender, _amount);
    }    

    function transferFrom(address _from, address _to, uint256 _value) public virtual  override returns (bool) {
        require(checkTransferFromAllowed(_from, _to, _value) == STATUS_ALLOWED, "transfer not allowed");
        if( hasRole(EXCHANGE_ROLE, _msgSender()) ) {
            ERC20Upgradeable._burn(_from, _value);
            ERC20Upgradeable._mint(_to, _value);
            //_transfer(_from, _to, _value); // revisar si puedo cambiar las dos lineas anteriores por esto
            return true;
        }
        return Utility.transferFrom(_from, _to, _value);
    }

    function mint(address _to, uint256 _amount) public virtual override onlyRole(EXCHANGE_ROLE) {
        require(checkMintAllowed(_to, _amount) == STATUS_ALLOWED, "mint not allowed");
        ERC20Upgradeable._mint(_to, _amount);
    }

    function burn(address _account, uint256 _amount) public virtual onlyRole(EXCHANGE_ROLE) {
        require(checkBurnAllowed(_account, _amount) == STATUS_ALLOWED, "burn not allowed");
        ERC20Upgradeable._burn(_account, _amount);
    }

    function checkTransferAllowed(address /*_from*/, address _to, uint256 _quantity) public virtual view returns (bytes1) {
        address _spender=_msgSender();
        //Si el spender no tiene rol de exchange
        if(!hasRole(EXCHANGE_ROLE, _spender)) {
            // verifico si esta pausado... sino sigo 
            _requireNotPaused(); 
        }        
        
        //  verifico whitelist para ver si quien recibe puede hacerlo y no excede el monto que tiene permitido
        // no verifico todo lo que el Utility ya verifica para ahorrar gas y código
        if(balanceOf(_to) + _quantity <= (whiteList[_to])) {
            return STATUS_ALLOWED ;
        }
        return STATUS_DISALLOWED ;
    }
   
    function checkTransferFromAllowed(address /*_from*/, address _to, uint256 _quantity) public virtual view returns (bytes1) {
        address _spender=_msgSender();
        //Si el spender no tiene rol de exchange
        if(!hasRole(EXCHANGE_ROLE, _spender)) {
            // verifico si esta pausado
            _requireNotPaused(); 
        }
        // y luego Verifico que se pueda transferir. Si tiene el rol, aunque esté pausado puede seguir
        // es igual a checkTransferAllowed. Pero no lo llamo para ahorrarme el jump a la funcion
        if(balanceOf(_to) + _quantity <= (whiteList[_to])) {
            return STATUS_ALLOWED ;
        }
        return STATUS_DISALLOWED ;
    }
   
    function checkMintAllowed(address _to, uint256 _quantity) public virtual view returns (bytes1) {
        //  verifico whitelist para ver si quien recibe puede hacerlo y no excede el monto que tiene permitido
        if(balanceOf(_to) + _quantity <= (whiteList[_to])) {
            // y le doy permiso
            if(totalSupply() + _quantity > maxMint) {
                return STATUS_DISALLOWED;
            }
            return STATUS_ALLOWED ;
        }
        return STATUS_DISALLOWED;
    }
   
    function checkBurnAllowed(address /*_from*/, uint256 /*_quantity*/) public virtual view returns (bytes1) {
        return STATUS_ALLOWED;
    }

}