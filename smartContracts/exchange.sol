// SPDX-License-Identifier: MIT
// Compatible with OpenZeppelin Contracts ^5.0.0
pragma solidity ^0.8.20;

import "@openzeppelin/contracts-upgradeable/utils/PausableUpgradeable.sol";
import "@openzeppelin/contracts-upgradeable/access/AccessControlUpgradeable.sol";
import "@openzeppelin/contracts-upgradeable/proxy/utils/Initializable.sol";
import "@openzeppelin/contracts-upgradeable/proxy/utils/UUPSUpgradeable.sol";
import "@openzeppelin/contracts/token/ERC20/IERC20.sol";
import "@openzeppelin/contracts/metatx/MinimalForwarder.sol";

// minimalForwarder = 0x0FF4843bBa0951e0Cd3076Dc4fa4db5411Fd3983
// exchange = 0x6C2aAd2A094CaFbe9C2633f4DfA65ef25155b7a8
// Proxy = 0x5f20BAE82e948120D2E7434342E3164C01F7FBD1

interface IERC20Mintable is IERC20 {
    function mint(address to, uint256 amount) external;
}

abstract contract ExchangeBase is Initializable, PausableUpgradeable, AccessControlUpgradeable, UUPSUpgradeable, MinimalForwarder {
    address internal _trustedForwarder;
    mapping (string => IERC20Mintable) public currency; // solo estables
    mapping (string => IERC20Mintable) public security; // solo propiedades
    mapping (string => uint8) decimals;
    mapping (string => address) public crowdfounding;// el addres a la que está ligado el security para recibir el dinero
    string[] securitiesListed;
    mapping (address => address) internal link_; // los address que van a estar linkeados cuando le damos a la whitelist
    mapping (address => uint256)   public whitelist; // cambie bool por uint256
    bytes32 public constant UPGRADER_ROLE = keccak256("UPGRADER_ROLE");
    bytes32 public constant PAUSER_ROLE = keccak256("PAUSER_ROLE");
    bytes32 public constant WHITELISTER_ROLE = keccak256("WHITELISTER_ROLE");
    bytes32 public constant PROJECTCREATOR_ROLE = keccak256("PROJECTCREATOR_ROLE");
    bytes32 public constant EXCHANGER_ROLE = keccak256("EXCHANGER_ROLE"); // se lo saque a compra() y ya no lo uso
    mapping (address => mapping (address => uint8)) public withdrawWallets;
    uint8 internal locked;

    mapping (address => uint256) public timeStamp;
    mapping (string => uint256) public bonus;
    uint256 internal  withdrawMinFee;
    uint256 internal withdrawFee;
    address internal feeAddress;
}

contract ExchangeOverride is ExchangeBase {

    function trustedForwarder() public view virtual returns (address) {
        return _trustedForwarder;
    }

    function isTrustedForwarder(address _forwarder) public view virtual returns (bool) {
        return _forwarder == trustedForwarder();
    }

    function _msgSender() internal view virtual override returns (address) {
        uint256 calldataLength = msg.data.length;
        uint256 contextSuffixLength = _contextSuffixLength();
        if (isTrustedForwarder(msg.sender) && calldataLength >= contextSuffixLength) {
            return address(bytes20(msg.data[calldataLength - contextSuffixLength:]));
        } else {
            return super._msgSender();
        }
    }

    function _msgData() internal view virtual override returns (bytes calldata) {
        uint256 calldataLength = msg.data.length;
        uint256 contextSuffixLength = _contextSuffixLength();
        if (isTrustedForwarder(msg.sender) && calldataLength >= contextSuffixLength) {
            return msg.data[:calldataLength - contextSuffixLength];
        } else {
            return super._msgData();
        }
    }

    function _contextSuffixLength() internal view virtual override returns (uint256) {
        return 20;
    }

    /// @custom:oz-upgrades-unsafe-allow constructor
    constructor() {
        _disableInitializers();
    }

    function initialize(address _forwarder) initializer public {
        require(_forwarder!=address(0x0),"trustedForwarder can't be null");
        __Pausable_init();
        __AccessControl_init();
        __UUPSUpgradeable_init();

        _grantRole(DEFAULT_ADMIN_ROLE, _msgSender());
        _grantRole(PAUSER_ROLE, _msgSender());
        _grantRole(UPGRADER_ROLE, _msgSender());
        _grantRole(WHITELISTER_ROLE, msg.sender);
        _grantRole(PROJECTCREATOR_ROLE, msg.sender);
        _grantRole(EXCHANGER_ROLE, msg.sender);

        _trustedForwarder = _forwarder;
    }

    function pause() public onlyRole(PAUSER_ROLE) {
        _pause();
    }

    function unpause() public onlyRole(PAUSER_ROLE) {
        _unpause();
    }

    function _authorizeUpgrade(address newImplementation) internal onlyRole(UPGRADER_ROLE) override {
    }
}

contract Exchange is ExchangeOverride {

    constructor() ExchangeOverride() {
    }

    event ProjectAdded(address indexed whoAdded, address indexed security, uint256 indexed timestamp, string curName, address funds);
    event CurrencyAdded(address indexed whoAdded, address indexed currency, uint256 indexed timestamp, string curName);
    event Trade(address indexed curSender, address indexed secReceiver, uint256 quantity, uint256 timestamp);
    event whiteListed(address indexed curAddr, address indexed secAddr, uint256 indexed timestamp, address whoAdded);
    
    event bonusGiven(address indexed _who, string indexed _project, uint256 _amount, uint256 _timestamp);
    event withdrawDone(address indexed _who, address indexed _from, address indexed _to, uint256 _amount, uint256 _feeAmount, string _tokenName, bool _fee, uint256 timestamp);
    event withdrawFeeChanged(address indexed _who, uint256 _withdrawMinFee, uint256 _withdrawFee, address indexed _feeAddress, uint256 timestamp);
    event WithdrawWalletChanged(address indexed _who, address indexed _from, address indexed _to, uint8 _value, uint256 timestamp);

    modifier nonReentrant() {
        require(locked!=1, "Reentrant call");
        locked = 1;
        _;
        locked = 2;
    }

    function setWithdrawWallets(address _from, address _to, uint8 _value) external onlyRole(WHITELISTER_ROLE) {
        withdrawWallets[_from][_to] = _value; // 2 es el unico valor de true.(1 para false)
        emit WithdrawWalletChanged(_msgSender(), _from, _to, _value, block.timestamp);
    }

    /*function clearWithdrawWallets(address _from, address _to) external onlyRole(WHITELISTER_ROLE) {
        withdrawWallets[_from][_to] = 1; // solo 2 es true. pongo 1 para que sea mas barato el gas
    }*/

    function checkWithdraw(address _from, address _to, uint256 _amount, string calldata _tokenName, bool _fee) public view returns(bool) {
        if (withdrawWallets[_from][_to] != 2) {
            return false;
        }
        if (_fee && _amount < withdrawMinFee) {
            return false;
        }
        return currency[_tokenName].balanceOf(_from) > _amount;
    }

    function withdraw(address _from, address _to, uint256 _amount, string calldata _tokenName, bool _fee) external onlyRole(EXCHANGER_ROLE) nonReentrant {
        require(checkWithdraw(_from, _to,_amount,_tokenName,_fee),"No se puede extraer");
        uint256 _feeAmount;
        if(_fee) {
            _feeAmount = _amount * withdrawFee/10000;
            uint256 _withdrawMinFee = withdrawMinFee;
            if(_feeAmount<_withdrawMinFee) {
                _feeAmount = _withdrawMinFee;
            }
            currency[_tokenName].transferFrom(_from,feeAddress,_feeAmount);
            _amount -= _feeAmount;
        }
        currency[_tokenName].transferFrom(_from,_to,_amount);
        emit withdrawDone(_msgSender(), _from,_to,_amount, _feeAmount, _tokenName,_fee, block.timestamp);
    }

    function setWithdrawFee(uint256 _withdrawMinFee, uint256 _withdrawFee, address _feeAddress) public onlyRole(EXCHANGER_ROLE) {
        require(_feeAddress != address(0));
        withdrawMinFee = _withdrawMinFee;
        withdrawFee = _withdrawFee;
        feeAddress = _feeAddress;
        emit withdrawFeeChanged(_msgSender(), _withdrawMinFee,  _withdrawFee, _feeAddress, block.timestamp);
    }

    function link(address _addr) public view returns (address) {
        if(whitelist[_addr]>0)
            return link_[_addr];
        else
            return address(0);
    }
    // deposit address y amount
    function acceptWhitelist(address _addr, uint256 _amount) public onlyRole(WHITELISTER_ROLE) {
        whitelist[_addr]=_amount;
        _addr = link_[_addr];
        require(_addr!=address(0),"not pending");
        whitelist[_addr]=_amount;
    }

    function setSecurity(string calldata _securityName, address _propiedad, address _funds, uint8 _decimals, uint256 _bonus) external onlyRole(PROJECTCREATOR_ROLE) {
        security[_securityName] = IERC20Mintable(_propiedad);
        crowdfounding[_securityName] = _funds;
        securitiesListed.push(_securityName);
        decimals[_securityName] = _decimals;
        bonus[_securityName] = _bonus;
        emit ProjectAdded(msg.sender, _propiedad, block.timestamp, _securityName, _funds);
    }

    function setCurrency(string calldata _currencyName, address _addr, uint8 _decimals) external onlyRole(PROJECTCREATOR_ROLE) {
        currency[_currencyName] = IERC20Mintable(_addr);
        decimals[_currencyName] = _decimals;
        emit CurrencyAdded(msg.sender, _addr, block.timestamp, _currencyName);
    }
    // deposit
    function setLink(address _link) external {
        require(link_[_link]==address(0x0),"already registered"); // no le dejo cambiar registros para que no pise a otros
        address _owner = _msgSender();
        link_[_owner]=_link;
        link_[_link]=_owner;// no debería hacer falta pero para probar ya que no me tomaba el linkeo
        emit whiteListed(_link, _owner, block.timestamp, _owner);
    }

    function setLinkManual(address _link, address _linkSemi) external onlyRole(WHITELISTER_ROLE) {
        link_[_linkSemi]=_link;
        link_[_link]=_linkSemi;// no debería hacer falta pero para probar ya que no me tomaba el linkeo
        emit whiteListed(_link, _linkSemi, block.timestamp, _msgSender());
    }    

    //moneda, token, cantidad
    // despues de comprar podemos leer whitelist[depositAddress]
    // si este es 0 podemos poner KYC=4
    // KYC = $ significa que el modal de invertir o cargar saldo diga que llegó al maximo que
    // puede operar y que debe contactarse con kyc_aml@comunyt.com para ampliar su limite anual.
    function comprar(string calldata _currency, string calldata _security, uint256 _amount) external whenNotPaused nonReentrant returns(bool _success) {
        require(_amount>1000000);
        require(crowdfounding[_security]!=address(0x0));
        address signer = _msgSender();
        address _from = link_[signer];
        require(_from!=address(0x0));  
        IERC20Mintable _token = currency[_currency];      
        IERC20Mintable _project = security[_security];  
        bool existToken =  (address(_token)!=address(0x0)) && (address(_project)!=address(0x0));
        require(existToken,"not existing token");  
        //require(address(_project)!=address(0x0),"not existing project");   

        uint256 _whitelistFrom;
        if(timeStamp[_from] < (block.timestamp - 365 days) ) {
            timeStamp[_from] = block.timestamp;
            _whitelistFrom =  whitelist[signer];
        }else {
            _whitelistFrom = whitelist[_from];
        }
        require(_whitelistFrom>0,"not whitelisted");
        if(_amount>_whitelistFrom) {
            _amount = _whitelistFrom;
            whitelist[_from] = 0;
        } else {
            whitelist[_from] = _whitelistFrom - _amount;
        }
        
        _token.transferFrom(_from, crowdfounding[_security], _amount);
        _project.transfer(signer, _amount);

        uint256 _bonus = bonus[_security];
        if(_bonus>0) {
            _bonus = _amount * _bonus /10000;
            currency["BTK"].mint(_from, _bonus);
            emit bonusGiven(_from,_security, _bonus, block.timestamp);
        }

        emit Trade(_from, signer, _amount, block.timestamp);
        return true;        

    }


}