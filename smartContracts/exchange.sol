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

abstract contract ExchangeBase is Initializable, PausableUpgradeable, AccessControlUpgradeable, UUPSUpgradeable, MinimalForwarder {
    address internal _trustedForwarder;
    mapping (string => IERC20) public currency; // solo estables
    mapping (string => IERC20) public security; // solo propiedades
    mapping (string => uint8) decimals;
    mapping (string => address) public crowdfounding;// el addres a la que está ligado el security para recibir el dinero
    string[] securitiesListed;
    mapping (address => address) internal link_; // los address que van a estar linkeados cuando le damos a la whitelist
    mapping (address => bool)   public whitelist;
    bytes32 public constant UPGRADER_ROLE = keccak256("UPGRADER_ROLE");
    bytes32 public constant PAUSER_ROLE = keccak256("PAUSER_ROLE");
    bytes32 public constant WHITELISTER_ROLE = keccak256("WHITELISTER_ROLE");
    bytes32 public constant PROJECTCREATOR_ROLE = keccak256("PROJECTCREATOR_ROLE");
    bytes32 public constant EXCHANGER_ROLE = keccak256("EXCHANGER_ROLE"); // se lo saque a compra() y ya no lo uso
    mapping (address => mapping (address => uint8)) public withdrawWallets;
    uint8 internal locked;
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
    event Trade(address indexed curSender, address indexed secReceiver, uint256 indexed timestamp, uint256 quantity);
    event whiteListed(address indexed curAddr, address indexed secAddr, uint256 indexed timestamp, address whoAdded);

    modifier nonReentrant() {
        require(locked!=1, "Reentrant call");
        locked = 1;
        _;
        locked = 2;
    }

    function setWithdrawWallets(address _from, address _to) external onlyRole(WHITELISTER_ROLE) {
        withdrawWallets[_from][_to] = 2; // unico valor de true
    }

    function clearWithdrawWallets(address _from, address _to) external onlyRole(WHITELISTER_ROLE) {
        withdrawWallets[_from][_to] = 1; // solo 2 es true. pongo 1 para que sea mas barato el gas
    }

    function checkWithdraw(address _from, address _to, uint256 _amount, string calldata _tokenName) public view onlyRole(EXCHANGER_ROLE) returns(bool) {
        if(withdrawWallets[_from][_to] == 2) {
            if(currency[_tokenName].balanceOf(_from) > _amount) {
                return true;
            }
        }
        return false;
    }

    function withdraw(address _from, address _to, uint256 _amount, string calldata _tokenName) external onlyRole(EXCHANGER_ROLE) nonReentrant {
        require(checkWithdraw(_from, _to,_amount,_tokenName),"No se puede extraer");
        currency[_tokenName].transferFrom(_from,_to,_amount);
    }

    function link(address _addr) public view returns (address) {
        if(whitelist[_addr])
            return link_[_addr];
        else
            return address(0);
    }

    function linkBach(address[] calldata _addr) public view returns (address[] memory result) {
        uint256 _size = _addr.length;
        for(uint256 i=0; i<_size; i++) {
            if(whitelist[_addr[i]])
                result[i] = link_[_addr[i]];
            else
                result[i] = address(0);            
        }
        return result;
    }

    function acceptWhitelist(address _addr) public onlyRole(WHITELISTER_ROLE) {
        require(link_[_addr]!=address(0),"not pending");
        whitelist[_addr]=true;
        whitelist[link_[_addr]]=true;
    }

    function setSecurity(string calldata _securityName, address _propiedad, address _funds, uint8 _decimals) external onlyRole(PROJECTCREATOR_ROLE) {
        security[_securityName] = IERC20(_propiedad);
        crowdfounding[_securityName] = _funds;
        securitiesListed.push(_securityName);
        decimals[_securityName] = _decimals;
        emit ProjectAdded(msg.sender, _propiedad, block.timestamp, _securityName, _funds);
    }

    function setCurrency(string calldata _currencyName, address _addr, uint8 _decimals) external onlyRole(PROJECTCREATOR_ROLE) {
        currency[_currencyName] = IERC20(_addr);
        decimals[_currencyName] = _decimals;
        emit CurrencyAdded(msg.sender, _addr, block.timestamp, _currencyName);
    }

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

    function comprar(string calldata _currency, string calldata _security, uint256 _amount) external whenNotPaused nonReentrant returns(bool _success) {
        address _from = link_[_msgSender()];
        require(_from!=address(0x0),"not sending from null");        
        uint8 decCur = decimals[_currency];
        uint8 decSec = decimals[_security];
        if(decCur == decSec) {
            currency[_currency].transferFrom(_from, crowdfounding[_security], _amount);
            security[_security].transfer(_msgSender(), _amount);
            emit Trade(_from, _msgSender(), block.timestamp, _amount);
            return true;        
        }
        uint8 difDec;
        if(decCur > decSec) {
            difDec = decCur - decSec;
            currency[_currency].transferFrom(_from, crowdfounding[_security], _amount);
            _amount = _amount / (10 ** difDec);
            security[_security].transfer(_msgSender(), _amount);      
        } else {
            difDec = decSec - decCur;
            currency[_currency].transferFrom(_from, crowdfounding[_security], _amount);
            _amount = _amount * (10 ** difDec);
            security[_security].transfer(_msgSender(), _amount);
        }
        emit Trade(_from, _msgSender(), block.timestamp, _amount);
        return true; 
    }


}