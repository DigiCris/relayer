    // SPDX-License-Identifier: MIT
    pragma solidity ^0.8.20;

    /**
    * @dev This is a base contract to aid in writing upgradeable contracts, or any kind of contract that will be deployed
    * behind a proxy. Since proxied contracts do not make use of a constructor, it's common to move constructor logic to an
    * external initializer function, usually called `initialize`. It then becomes necessary to protect this initializer
    * function so it can only be called once. The {initializer} modifier provided by this contract will have this effect.
    *
    * The initialization functions use a version number. Once a version number is used, it is consumed and cannot be
    * reused. This mechanism prevents re-execution of each "step" but allows the creation of new initialization steps in
    * case an upgrade adds a module that needs to be initialized.
    *
    * For example:
    *
    * [.hljs-theme-light.nopadding]
    * ```solidity
    * contract MyToken is ERC20Upgradeable {
    *     function initialize() initializer public {
    *         __ERC20_init("MyToken", "MTK");
    *     }
    * }
    *
    * contract MyTokenV2 is MyToken, ERC20PermitUpgradeable {
    *     function initializeV2() reinitializer(2) public {
    *         __ERC20Permit_init("MyToken");
    *     }
    * }
    * ```
    *
    * TIP: To avoid leaving the proxy in an uninitialized state, the initializer function should be called as early as
    * possible by providing the encoded function call as the `_data` argument to {ERC1967Proxy-constructor}.
    *
    * CAUTION: When used with inheritance, manual care must be taken to not invoke a parent initializer twice, or to ensure
    * that all initializers are idempotent. This is not verified automatically as constructors are by Solidity.
    *
    * [CAUTION]
    * ====
    * Avoid leaving a contract uninitialized.
    *
    * An uninitialized contract can be taken over by an attacker. This applies to both a proxy and its implementation
    * contract, which may impact the proxy. To prevent the implementation contract from being used, you should invoke
    * the {_disableInitializers} function in the constructor to automatically lock it when it is deployed:
    *
    * [.hljs-theme-light.nopadding]
    * ```
    * /// @custom:oz-upgrades-unsafe-allow constructor
    * constructor() {
    *     _disableInitializers();
    * }
    * ```
    * ====
    */
    abstract contract Initializable {
        /**
        * @dev Storage of the initializable contract.
        *
        * It's implemented on a custom ERC-7201 namespace to reduce the risk of storage collisions
        * when using with upgradeable contracts.
        *
        * @custom:storage-location erc7201:openzeppelin.storage.Initializable
        */
        struct InitializableStorage {
            /**
            * @dev Indicates that the contract has been initialized.
            */
            uint64 _initialized;
            /**
            * @dev Indicates that the contract is in the process of being initialized.
            */
            bool _initializing;
        }

        // keccak256(abi.encode(uint256(keccak256("openzeppelin.storage.Initializable")) - 1)) & ~bytes32(uint256(0xff))
        bytes32 private constant INITIALIZABLE_STORAGE = 0xf0c57e16840df040f15088dc2f81fe391c3923bec73e23a9662efc9c229c6a00;

        /**
        * @dev The contract is already initialized.
        */
        error InvalidInitialization();

        /**
        * @dev The contract is not initializing.
        */
        error NotInitializing();

        /**
        * @dev Triggered when the contract has been initialized or reinitialized.
        */
        event Initialized(uint64 version);

        /**
        * @dev A modifier that defines a protected initializer function that can be invoked at most once. In its scope,
        * `onlyInitializing` functions can be used to initialize parent contracts.
        *
        * Similar to `reinitializer(1)`, except that in the context of a constructor an `initializer` may be invoked any
        * number of times. This behavior in the constructor can be useful during testing and is not expected to be used in
        * production.
        *
        * Emits an {Initialized} event.
        */
        modifier initializer() {
            // solhint-disable-next-line var-name-mixedcase
            InitializableStorage storage $ = _getInitializableStorage();

            // Cache values to avoid duplicated sloads
            bool isTopLevelCall = !$._initializing;
            uint64 initialized = $._initialized;

            // Allowed calls:
            // - initialSetup: the contract is not in the initializing state and no previous version was
            //                 initialized
            // - construction: the contract is initialized at version 1 (no reininitialization) and the
            //                 current contract is just being deployed
            bool initialSetup = initialized == 0 && isTopLevelCall;
            bool construction = initialized == 1 && address(this).code.length == 0;

            if (!initialSetup && !construction) {
                revert InvalidInitialization();
            }
            $._initialized = 1;
            if (isTopLevelCall) {
                $._initializing = true;
            }
            _;
            if (isTopLevelCall) {
                $._initializing = false;
                emit Initialized(1);
            }
        }

        /**
        * @dev A modifier that defines a protected reinitializer function that can be invoked at most once, and only if the
        * contract hasn't been initialized to a greater version before. In its scope, `onlyInitializing` functions can be
        * used to initialize parent contracts.
        *
        * A reinitializer may be used after the original initialization step. This is essential to configure modules that
        * are added through upgrades and that require initialization.
        *
        * When `version` is 1, this modifier is similar to `initializer`, except that functions marked with `reinitializer`
        * cannot be nested. If one is invoked in the context of another, execution will revert.
        *
        * Note that versions can jump in increments greater than 1; this implies that if multiple reinitializers coexist in
        * a contract, executing them in the right order is up to the developer or operator.
        *
        * WARNING: Setting the version to 2**64 - 1 will prevent any future reinitialization.
        *
        * Emits an {Initialized} event.
        */
        modifier reinitializer(uint64 version) {
            // solhint-disable-next-line var-name-mixedcase
            InitializableStorage storage $ = _getInitializableStorage();

            if ($._initializing || $._initialized >= version) {
                revert InvalidInitialization();
            }
            $._initialized = version;
            $._initializing = true;
            _;
            $._initializing = false;
            emit Initialized(version);
        }

        /**
        * @dev Modifier to protect an initialization function so that it can only be invoked by functions with the
        * {initializer} and {reinitializer} modifiers, directly or indirectly.
        */
        modifier onlyInitializing() {
            _checkInitializing();
            _;
        }

        /**
        * @dev Reverts if the contract is not in an initializing state. See {onlyInitializing}.
        */
        function _checkInitializing() internal view virtual {
            if (!_isInitializing()) {
                revert NotInitializing();
            }
        }

        /**
        * @dev Locks the contract, preventing any future reinitialization. This cannot be part of an initializer call.
        * Calling this in the constructor of a contract will prevent that contract from being initialized or reinitialized
        * to any version. It is recommended to use this to lock implementation contracts that are designed to be called
        * through proxies.
        *
        * Emits an {Initialized} event the first time it is successfully executed.
        */
        function _disableInitializers() internal virtual {
            // solhint-disable-next-line var-name-mixedcase
            InitializableStorage storage $ = _getInitializableStorage();

            if ($._initializing) {
                revert InvalidInitialization();
            }
            if ($._initialized != type(uint64).max) {
                $._initialized = type(uint64).max;
                emit Initialized(type(uint64).max);
            }
        }

        /**
        * @dev Returns the highest version that has been initialized. See {reinitializer}.
        */
        function _getInitializedVersion() internal view returns (uint64) {
            return _getInitializableStorage()._initialized;
        }

        /**
        * @dev Returns `true` if the contract is currently initializing. See {onlyInitializing}.
        */
        function _isInitializing() internal view returns (bool) {
            return _getInitializableStorage()._initializing;
        }

        /**
        * @dev Returns a pointer to the storage namespace.
        */
        // solhint-disable-next-line var-name-mixedcase
        function _getInitializableStorage() private pure returns (InitializableStorage storage $) {
            assembly {
                $.slot := INITIALIZABLE_STORAGE
            }
        }
    }


    // File @openzeppelin/contracts-upgradeable/utils/ContextUpgradeable.sol@v5.0.2

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.1) (utils/Context.sol)

    //pragma solidity ^0.8.20;

    /**
    * @dev Provides information about the current execution context, including the
    * sender of the transaction and its data. While these are generally available
    * via msg.sender and msg.data, they should not be accessed in such a direct
    * manner, since when dealing with meta-transactions the account sending and
    * paying for execution may not be the actual sender (as far as an application
    * is concerned).
    *
    * This contract is only required for intermediate, library-like contracts.
    */
    abstract contract ContextUpgradeable is Initializable {
        function __Context_init() internal onlyInitializing {
        }

        function __Context_init_unchained() internal onlyInitializing {
        }
        function _msgSender() internal view virtual returns (address) {
            return msg.sender;
        }

        function _msgData() internal view virtual returns (bytes calldata) {
            return msg.data;
        }

        function _contextSuffixLength() internal view virtual returns (uint256) {
            return 0;
        }
    }


    // File @openzeppelin/contracts/utils/introspection/IERC165.sol@v5.0.2

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (utils/introspection/IERC165.sol)

    //pragma solidity ^0.8.20;

    /**
    * @dev Interface of the ERC165 standard, as defined in the
    * https://eips.ethereum.org/EIPS/eip-165[EIP].
    *
    * Implementers can declare support of contract interfaces, which can then be
    * queried by others ({ERC165Checker}).
    *
    * For an implementation, see {ERC165}.
    */
    interface IERC165 {
        /**
        * @dev Returns true if this contract implements the interface defined by
        * `interfaceId`. See the corresponding
        * https://eips.ethereum.org/EIPS/eip-165#how-interfaces-are-identified[EIP section]
        * to learn more about how these ids are created.
        *
        * This function call must use less than 30 000 gas.
        */
        function supportsInterface(bytes4 interfaceId) external view returns (bool);
    }


    // File @openzeppelin/contracts-upgradeable/utils/introspection/ERC165Upgradeable.sol@v5.0.2

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (utils/introspection/ERC165.sol)

    //pragma solidity ^0.8.20;


    /**
    * @dev Implementation of the {IERC165} interface.
    *
    * Contracts that want to implement ERC165 should inherit from this contract and override {supportsInterface} to check
    * for the additional interface id that will be supported. For example:
    *
    * ```solidity
    * function supportsInterface(bytes4 interfaceId) public view virtual override returns (bool) {
    *     return interfaceId == type(MyInterface).interfaceId || super.supportsInterface(interfaceId);
    * }
    * ```
    */
    abstract contract ERC165Upgradeable is Initializable, IERC165 {
        function __ERC165_init() internal onlyInitializing {
        }

        function __ERC165_init_unchained() internal onlyInitializing {
        }
        /**
        * @dev See {IERC165-supportsInterface}.
        */
        function supportsInterface(bytes4 interfaceId) public view virtual returns (bool) {
            return interfaceId == type(IERC165).interfaceId;
        }
    }


    // File @openzeppelin/contracts/access/IAccessControl.sol@v5.0.2

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (access/IAccessControl.sol)

    //pragma solidity ^0.8.20;

    /**
    * @dev External interface of AccessControl declared to support ERC165 detection.
    */
    interface IAccessControl {
        /**
        * @dev The `account` is missing a role.
        */
        error AccessControlUnauthorizedAccount(address account, bytes32 neededRole);

        /**
        * @dev The caller of a function is not the expected one.
        *
        * NOTE: Don't confuse with {AccessControlUnauthorizedAccount}.
        */
        error AccessControlBadConfirmation();

        /**
        * @dev Emitted when `newAdminRole` is set as ``role``'s admin role, replacing `previousAdminRole`
        *
        * `DEFAULT_ADMIN_ROLE` is the starting admin for all roles, despite
        * {RoleAdminChanged} not being emitted signaling this.
        */
        event RoleAdminChanged(bytes32 indexed role, bytes32 indexed previousAdminRole, bytes32 indexed newAdminRole);

        /**
        * @dev Emitted when `account` is granted `role`.
        *
        * `sender` is the account that originated the contract call, an admin role
        * bearer except when using {AccessControl-_setupRole}.
        */
        event RoleGranted(bytes32 indexed role, address indexed account, address indexed sender);

        /**
        * @dev Emitted when `account` is revoked `role`.
        *
        * `sender` is the account that originated the contract call:
        *   - if using `revokeRole`, it is the admin role bearer
        *   - if using `renounceRole`, it is the role bearer (i.e. `account`)
        */
        event RoleRevoked(bytes32 indexed role, address indexed account, address indexed sender);

        /**
        * @dev Returns `true` if `account` has been granted `role`.
        */
        function hasRole(bytes32 role, address account) external view returns (bool);

        /**
        * @dev Returns the admin role that controls `role`. See {grantRole} and
        * {revokeRole}.
        *
        * To change a role's admin, use {AccessControl-_setRoleAdmin}.
        */
        function getRoleAdmin(bytes32 role) external view returns (bytes32);

        /**
        * @dev Grants `role` to `account`.
        *
        * If `account` had not been already granted `role`, emits a {RoleGranted}
        * event.
        *
        * Requirements:
        *
        * - the caller must have ``role``'s admin role.
        */
        function grantRole(bytes32 role, address account) external;

        /**
        * @dev Revokes `role` from `account`.
        *
        * If `account` had been granted `role`, emits a {RoleRevoked} event.
        *
        * Requirements:
        *
        * - the caller must have ``role``'s admin role.
        */
        function revokeRole(bytes32 role, address account) external;

        /**
        * @dev Revokes `role` from the calling account.
        *
        * Roles are often managed via {grantRole} and {revokeRole}: this function's
        * purpose is to provide a mechanism for accounts to lose their privileges
        * if they are compromised (such as when a trusted device is misplaced).
        *
        * If the calling account had been granted `role`, emits a {RoleRevoked}
        * event.
        *
        * Requirements:
        *
        * - the caller must be `callerConfirmation`.
        */
        function renounceRole(bytes32 role, address callerConfirmation) external;
    }


    // File @openzeppelin/contracts-upgradeable/access/AccessControlUpgradeable.sol@v5.0.2

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (access/AccessControl.sol)

    //pragma solidity ^0.8.20;




    /**
    * @dev Contract module that allows children to implement role-based access
    * control mechanisms. This is a lightweight version that doesn't allow enumerating role
    * members except through off-chain means by accessing the contract event logs. Some
    * applications may benefit from on-chain enumerability, for those cases see
    * {AccessControlEnumerable}.
    *
    * Roles are referred to by their `bytes32` identifier. These should be exposed
    * in the external API and be unique. The best way to achieve this is by
    * using `public constant` hash digests:
    *
    * ```solidity
    * bytes32 public constant MY_ROLE = keccak256("MY_ROLE");
    * ```
    *
    * Roles can be used to represent a set of permissions. To restrict access to a
    * function call, use {hasRole}:
    *
    * ```solidity
    * function foo() public {
    *     require(hasRole(MY_ROLE, msg.sender));
    *     ...
    * }
    * ```
    *
    * Roles can be granted and revoked dynamically via the {grantRole} and
    * {revokeRole} functions. Each role has an associated admin role, and only
    * accounts that have a role's admin role can call {grantRole} and {revokeRole}.
    *
    * By default, the admin role for all roles is `DEFAULT_ADMIN_ROLE`, which means
    * that only accounts with this role will be able to grant or revoke other
    * roles. More complex role relationships can be created by using
    * {_setRoleAdmin}.
    *
    * WARNING: The `DEFAULT_ADMIN_ROLE` is also its own admin: it has permission to
    * grant and revoke this role. Extra precautions should be taken to secure
    * accounts that have been granted it. We recommend using {AccessControlDefaultAdminRules}
    * to enforce additional security measures for this role.
    */
    abstract contract AccessControlUpgradeable is Initializable, ContextUpgradeable, IAccessControl, ERC165Upgradeable {
        struct RoleData {
            mapping(address account => bool) hasRole;
            bytes32 adminRole;
        }

        bytes32 public constant DEFAULT_ADMIN_ROLE = 0x00;


        /// @custom:storage-location erc7201:openzeppelin.storage.AccessControl
        struct AccessControlStorage {
            mapping(bytes32 role => RoleData) _roles;
        }

        // keccak256(abi.encode(uint256(keccak256("openzeppelin.storage.AccessControl")) - 1)) & ~bytes32(uint256(0xff))
        bytes32 private constant AccessControlStorageLocation = 0x02dd7bc7dec4dceedda775e58dd541e08a116c6c53815c0bd028192f7b626800;

        function _getAccessControlStorage() private pure returns (AccessControlStorage storage $) {
            assembly {
                $.slot := AccessControlStorageLocation
            }
        }

        /**
        * @dev Modifier that checks that an account has a specific role. Reverts
        * with an {AccessControlUnauthorizedAccount} error including the required role.
        */
        modifier onlyRole(bytes32 role) {
            _checkRole(role);
            _;
        }

        function __AccessControl_init() internal onlyInitializing {
        }

        function __AccessControl_init_unchained() internal onlyInitializing {
        }
        /**
        * @dev See {IERC165-supportsInterface}.
        */
        function supportsInterface(bytes4 interfaceId) public view virtual override returns (bool) {
            return interfaceId == type(IAccessControl).interfaceId || super.supportsInterface(interfaceId);
        }

        /**
        * @dev Returns `true` if `account` has been granted `role`.
        */
        function hasRole(bytes32 role, address account) public view virtual returns (bool) {
            AccessControlStorage storage $ = _getAccessControlStorage();
            return $._roles[role].hasRole[account];
        }

        /**
        * @dev Reverts with an {AccessControlUnauthorizedAccount} error if `_msgSender()`
        * is missing `role`. Overriding this function changes the behavior of the {onlyRole} modifier.
        */
        function _checkRole(bytes32 role) internal view virtual {
            _checkRole(role, _msgSender());
        }

        /**
        * @dev Reverts with an {AccessControlUnauthorizedAccount} error if `account`
        * is missing `role`.
        */
        function _checkRole(bytes32 role, address account) internal view virtual {
            if (!hasRole(role, account)) {
                revert AccessControlUnauthorizedAccount(account, role);
            }
        }

        /**
        * @dev Returns the admin role that controls `role`. See {grantRole} and
        * {revokeRole}.
        *
        * To change a role's admin, use {_setRoleAdmin}.
        */
        function getRoleAdmin(bytes32 role) public view virtual returns (bytes32) {
            AccessControlStorage storage $ = _getAccessControlStorage();
            return $._roles[role].adminRole;
        }

        /**
        * @dev Grants `role` to `account`.
        *
        * If `account` had not been already granted `role`, emits a {RoleGranted}
        * event.
        *
        * Requirements:
        *
        * - the caller must have ``role``'s admin role.
        *
        * May emit a {RoleGranted} event.
        */
        function grantRole(bytes32 role, address account) public virtual onlyRole(getRoleAdmin(role)) {
            _grantRole(role, account);
        }

        /**
        * @dev Revokes `role` from `account`.
        *
        * If `account` had been granted `role`, emits a {RoleRevoked} event.
        *
        * Requirements:
        *
        * - the caller must have ``role``'s admin role.
        *
        * May emit a {RoleRevoked} event.
        */
        function revokeRole(bytes32 role, address account) public virtual onlyRole(getRoleAdmin(role)) {
            _revokeRole(role, account);
        }

        /**
        * @dev Revokes `role` from the calling account.
        *
        * Roles are often managed via {grantRole} and {revokeRole}: this function's
        * purpose is to provide a mechanism for accounts to lose their privileges
        * if they are compromised (such as when a trusted device is misplaced).
        *
        * If the calling account had been revoked `role`, emits a {RoleRevoked}
        * event.
        *
        * Requirements:
        *
        * - the caller must be `callerConfirmation`.
        *
        * May emit a {RoleRevoked} event.
        */
        function renounceRole(bytes32 role, address callerConfirmation) public virtual {
            if (callerConfirmation != _msgSender()) {
                revert AccessControlBadConfirmation();
            }

            _revokeRole(role, callerConfirmation);
        }

        /**
        * @dev Sets `adminRole` as ``role``'s admin role.
        *
        * Emits a {RoleAdminChanged} event.
        */
        function _setRoleAdmin(bytes32 role, bytes32 adminRole) internal virtual {
            AccessControlStorage storage $ = _getAccessControlStorage();
            bytes32 previousAdminRole = getRoleAdmin(role);
            $._roles[role].adminRole = adminRole;
            emit RoleAdminChanged(role, previousAdminRole, adminRole);
        }

        /**
        * @dev Attempts to grant `role` to `account` and returns a boolean indicating if `role` was granted.
        *
        * Internal function without access restriction.
        *
        * May emit a {RoleGranted} event.
        */
        function _grantRole(bytes32 role, address account) internal virtual returns (bool) {
            AccessControlStorage storage $ = _getAccessControlStorage();
            if (!hasRole(role, account)) {
                $._roles[role].hasRole[account] = true;
                emit RoleGranted(role, account, _msgSender());
                return true;
            } else {
                return false;
            }
        }

        /**
        * @dev Attempts to revoke `role` to `account` and returns a boolean indicating if `role` was revoked.
        *
        * Internal function without access restriction.
        *
        * May emit a {RoleRevoked} event.
        */
        function _revokeRole(bytes32 role, address account) internal virtual returns (bool) {
            AccessControlStorage storage $ = _getAccessControlStorage();
            if (hasRole(role, account)) {
                $._roles[role].hasRole[account] = false;
                emit RoleRevoked(role, account, _msgSender());
                return true;
            } else {
                return false;
            }
        }
    }


    // File @openzeppelin/contracts/interfaces/draft-IERC1822.sol@v5.0.2

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (interfaces/draft-IERC1822.sol)

    //pragma solidity ^0.8.20;

    /**
    * @dev ERC1822: Universal Upgradeable Proxy Standard (UUPS) documents a method for upgradeability through a simplified
    * proxy whose upgrades are fully controlled by the current implementation.
    */
    interface IERC1822Proxiable {
        /**
        * @dev Returns the storage slot that the proxiable contract assumes is being used to store the implementation
        * address.
        *
        * IMPORTANT: A proxy pointing at a proxiable contract should not be considered proxiable itself, because this risks
        * bricking a proxy that upgrades to it, by delegating to itself until out of gas. Thus it is critical that this
        * function revert if invoked through a proxy.
        */
        function proxiableUUID() external view returns (bytes32);
    }


    // File @openzeppelin/contracts/proxy/beacon/IBeacon.sol@v5.0.2

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (proxy/beacon/IBeacon.sol)

    //pragma solidity ^0.8.20;

    /**
    * @dev This is the interface that {BeaconProxy} expects of its beacon.
    */
    interface IBeacon {
        /**
        * @dev Must return an address that can be used as a delegate call target.
        *
        * {UpgradeableBeacon} will check that this address is a contract.
        */
        function implementation() external view returns (address);
    }


    // File @openzeppelin/contracts/utils/Address.sol@v5.0.2

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (utils/Address.sol)

    //pragma solidity ^0.8.20;

    /**
    * @dev Collection of functions related to the address type
    */
    library Address {
        /**
        * @dev The ETH balance of the account is not enough to perform the operation.
        */
        error AddressInsufficientBalance(address account);

        /**
        * @dev There's no code at `target` (it is not a contract).
        */
        error AddressEmptyCode(address target);

        /**
        * @dev A call to an address target failed. The target may have reverted.
        */
        error FailedInnerCall();

        /**
        * @dev Replacement for Solidity's `transfer`: sends `amount` wei to
        * `recipient`, forwarding all available gas and reverting on errors.
        *
        * https://eips.ethereum.org/EIPS/eip-1884[EIP1884] increases the gas cost
        * of certain opcodes, possibly making contracts go over the 2300 gas limit
        * imposed by `transfer`, making them unable to receive funds via
        * `transfer`. {sendValue} removes this limitation.
        *
        * https://consensys.net/diligence/blog/2019/09/stop-using-soliditys-transfer-now/[Learn more].
        *
        * IMPORTANT: because control is transferred to `recipient`, care must be
        * taken to not create reentrancy vulnerabilities. Consider using
        * {ReentrancyGuard} or the
        * https://solidity.readthedocs.io/en/v0.8.20/security-considerations.html#use-the-checks-effects-interactions-pattern[checks-effects-interactions pattern].
        */
        function sendValue(address payable recipient, uint256 amount) internal {
            if (address(this).balance < amount) {
                revert AddressInsufficientBalance(address(this));
            }

            (bool success, ) = recipient.call{value: amount}("");
            if (!success) {
                revert FailedInnerCall();
            }
        }

        /**
        * @dev Performs a Solidity function call using a low level `call`. A
        * plain `call` is an unsafe replacement for a function call: use this
        * function instead.
        *
        * If `target` reverts with a revert reason or custom error, it is bubbled
        * up by this function (like regular Solidity function calls). However, if
        * the call reverted with no returned reason, this function reverts with a
        * {FailedInnerCall} error.
        *
        * Returns the raw returned data. To convert to the expected return value,
        * use https://solidity.readthedocs.io/en/latest/units-and-global-variables.html?highlight=abi.decode#abi-encoding-and-decoding-functions[`abi.decode`].
        *
        * Requirements:
        *
        * - `target` must be a contract.
        * - calling `target` with `data` must not revert.
        */
        function functionCall(address target, bytes memory data) internal returns (bytes memory) {
            return functionCallWithValue(target, data, 0);
        }

        /**
        * @dev Same as {xref-Address-functionCall-address-bytes-}[`functionCall`],
        * but also transferring `value` wei to `target`.
        *
        * Requirements:
        *
        * - the calling contract must have an ETH balance of at least `value`.
        * - the called Solidity function must be `payable`.
        */
        function functionCallWithValue(address target, bytes memory data, uint256 value) internal returns (bytes memory) {
            if (address(this).balance < value) {
                revert AddressInsufficientBalance(address(this));
            }
            (bool success, bytes memory returndata) = target.call{value: value}(data);
            return verifyCallResultFromTarget(target, success, returndata);
        }

        /**
        * @dev Same as {xref-Address-functionCall-address-bytes-}[`functionCall`],
        * but performing a static call.
        */
        function functionStaticCall(address target, bytes memory data) internal view returns (bytes memory) {
            (bool success, bytes memory returndata) = target.staticcall(data);
            return verifyCallResultFromTarget(target, success, returndata);
        }

        /**
        * @dev Same as {xref-Address-functionCall-address-bytes-}[`functionCall`],
        * but performing a delegate call.
        */
        function functionDelegateCall(address target, bytes memory data) internal returns (bytes memory) {
            (bool success, bytes memory returndata) = target.delegatecall(data);
            return verifyCallResultFromTarget(target, success, returndata);
        }

        /**
        * @dev Tool to verify that a low level call to smart-contract was successful, and reverts if the target
        * was not a contract or bubbling up the revert reason (falling back to {FailedInnerCall}) in case of an
        * unsuccessful call.
        */
        function verifyCallResultFromTarget(
            address target,
            bool success,
            bytes memory returndata
        ) internal view returns (bytes memory) {
            if (!success) {
                _revert(returndata);
            } else {
                // only check if target is a contract if the call was successful and the return data is empty
                // otherwise we already know that it was a contract
                if (returndata.length == 0 && target.code.length == 0) {
                    revert AddressEmptyCode(target);
                }
                return returndata;
            }
        }

        /**
        * @dev Tool to verify that a low level call was successful, and reverts if it wasn't, either by bubbling the
        * revert reason or with a default {FailedInnerCall} error.
        */
        function verifyCallResult(bool success, bytes memory returndata) internal pure returns (bytes memory) {
            if (!success) {
                _revert(returndata);
            } else {
                return returndata;
            }
        }

        /**
        * @dev Reverts with returndata if present. Otherwise reverts with {FailedInnerCall}.
        */
        function _revert(bytes memory returndata) private pure {
            // Look for revert reason and bubble it up if present
            if (returndata.length > 0) {
                // The easiest way to bubble the revert reason is using memory via assembly
                /// @solidity memory-safe-assembly
                assembly {
                    let returndata_size := mload(returndata)
                    revert(add(32, returndata), returndata_size)
                }
            } else {
                revert FailedInnerCall();
            }
        }
    }


    // File @openzeppelin/contracts/utils/StorageSlot.sol@v5.0.2

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (utils/StorageSlot.sol)
    // This file was procedurally generated from scripts/generate/templates/StorageSlot.js.

    //pragma solidity ^0.8.20;

    /**
    * @dev Library for reading and writing primitive types to specific storage slots.
    *
    * Storage slots are often used to avoid storage conflict when dealing with upgradeable contracts.
    * This library helps with reading and writing to such slots without the need for inline assembly.
    *
    * The functions in this library return Slot structs that contain a `value` member that can be used to read or write.
    *
    * Example usage to set ERC1967 implementation slot:
    * ```solidity
    * contract ERC1967 {
    *     bytes32 internal constant _IMPLEMENTATION_SLOT = 0x360894a13ba1a3210667c828492db98dca3e2076cc3735a920a3ca505d382bbc;
    *
    *     function _getImplementation() internal view returns (address) {
    *         return StorageSlot.getAddressSlot(_IMPLEMENTATION_SLOT).value;
    *     }
    *
    *     function _setImplementation(address newImplementation) internal {
    *         require(newImplementation.code.length > 0);
    *         StorageSlot.getAddressSlot(_IMPLEMENTATION_SLOT).value = newImplementation;
    *     }
    * }
    * ```
    */
    library StorageSlot {
        struct AddressSlot {
            address value;
        }

        struct BooleanSlot {
            bool value;
        }

        struct Bytes32Slot {
            bytes32 value;
        }

        struct Uint256Slot {
            uint256 value;
        }

        struct StringSlot {
            string value;
        }

        struct BytesSlot {
            bytes value;
        }

        /**
        * @dev Returns an `AddressSlot` with member `value` located at `slot`.
        */
        function getAddressSlot(bytes32 slot) internal pure returns (AddressSlot storage r) {
            /// @solidity memory-safe-assembly
            assembly {
                r.slot := slot
            }
        }

        /**
        * @dev Returns an `BooleanSlot` with member `value` located at `slot`.
        */
        function getBooleanSlot(bytes32 slot) internal pure returns (BooleanSlot storage r) {
            /// @solidity memory-safe-assembly
            assembly {
                r.slot := slot
            }
        }

        /**
        * @dev Returns an `Bytes32Slot` with member `value` located at `slot`.
        */
        function getBytes32Slot(bytes32 slot) internal pure returns (Bytes32Slot storage r) {
            /// @solidity memory-safe-assembly
            assembly {
                r.slot := slot
            }
        }

        /**
        * @dev Returns an `Uint256Slot` with member `value` located at `slot`.
        */
        function getUint256Slot(bytes32 slot) internal pure returns (Uint256Slot storage r) {
            /// @solidity memory-safe-assembly
            assembly {
                r.slot := slot
            }
        }

        /**
        * @dev Returns an `StringSlot` with member `value` located at `slot`.
        */
        function getStringSlot(bytes32 slot) internal pure returns (StringSlot storage r) {
            /// @solidity memory-safe-assembly
            assembly {
                r.slot := slot
            }
        }

        /**
        * @dev Returns an `StringSlot` representation of the string storage pointer `store`.
        */
        function getStringSlot(string storage store) internal pure returns (StringSlot storage r) {
            /// @solidity memory-safe-assembly
            assembly {
                r.slot := store.slot
            }
        }

        /**
        * @dev Returns an `BytesSlot` with member `value` located at `slot`.
        */
        function getBytesSlot(bytes32 slot) internal pure returns (BytesSlot storage r) {
            /// @solidity memory-safe-assembly
            assembly {
                r.slot := slot
            }
        }

        /**
        * @dev Returns an `BytesSlot` representation of the bytes storage pointer `store`.
        */
        function getBytesSlot(bytes storage store) internal pure returns (BytesSlot storage r) {
            /// @solidity memory-safe-assembly
            assembly {
                r.slot := store.slot
            }
        }
    }


    // File @openzeppelin/contracts/proxy/ERC1967/ERC1967Utils.sol@v5.0.2

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (proxy/ERC1967/ERC1967Utils.sol)

    //pragma solidity ^0.8.20;



    /**
    * @dev This abstract contract provides getters and event emitting update functions for
    * https://eips.ethereum.org/EIPS/eip-1967[EIP1967] slots.
    */
    library ERC1967Utils {
        // We re-declare ERC-1967 events here because they can't be used directly from IERC1967.
        // This will be fixed in Solidity 0.8.21. At that point we should remove these events.
        /**
        * @dev Emitted when the implementation is upgraded.
        */
        event Upgraded(address indexed implementation);

        /**
        * @dev Emitted when the admin account has changed.
        */
        event AdminChanged(address previousAdmin, address newAdmin);

        /**
        * @dev Emitted when the beacon is changed.
        */
        event BeaconUpgraded(address indexed beacon);

        /**
        * @dev Storage slot with the address of the current implementation.
        * This is the keccak-256 hash of "eip1967.proxy.implementation" subtracted by 1.
        */
        // solhint-disable-next-line private-vars-leading-underscore
        bytes32 internal constant IMPLEMENTATION_SLOT = 0x360894a13ba1a3210667c828492db98dca3e2076cc3735a920a3ca505d382bbc;

        /**
        * @dev The `implementation` of the proxy is invalid.
        */
        error ERC1967InvalidImplementation(address implementation);

        /**
        * @dev The `admin` of the proxy is invalid.
        */
        error ERC1967InvalidAdmin(address admin);

        /**
        * @dev The `beacon` of the proxy is invalid.
        */
        error ERC1967InvalidBeacon(address beacon);

        /**
        * @dev An upgrade function sees `msg.value > 0` that may be lost.
        */
        error ERC1967NonPayable();

        /**
        * @dev Returns the current implementation address.
        */
        function getImplementation() internal view returns (address) {
            return StorageSlot.getAddressSlot(IMPLEMENTATION_SLOT).value;
        }

        /**
        * @dev Stores a new address in the EIP1967 implementation slot.
        */
        function _setImplementation(address newImplementation) private {
            if (newImplementation.code.length == 0) {
                revert ERC1967InvalidImplementation(newImplementation);
            }
            StorageSlot.getAddressSlot(IMPLEMENTATION_SLOT).value = newImplementation;
        }

        /**
        * @dev Performs implementation upgrade with additional setup call if data is nonempty.
        * This function is payable only if the setup call is performed, otherwise `msg.value` is rejected
        * to avoid stuck value in the contract.
        *
        * Emits an {IERC1967-Upgraded} event.
        */
        function upgradeToAndCall(address newImplementation, bytes memory data) internal {
            _setImplementation(newImplementation);
            emit Upgraded(newImplementation);

            if (data.length > 0) {
                Address.functionDelegateCall(newImplementation, data);
            } else {
                _checkNonPayable();
            }
        }

        /**
        * @dev Storage slot with the admin of the contract.
        * This is the keccak-256 hash of "eip1967.proxy.admin" subtracted by 1.
        */
        // solhint-disable-next-line private-vars-leading-underscore
        bytes32 internal constant ADMIN_SLOT = 0xb53127684a568b3173ae13b9f8a6016e243e63b6e8ee1178d6a717850b5d6103;

        /**
        * @dev Returns the current admin.
        *
        * TIP: To get this value clients can read directly from the storage slot shown below (specified by EIP1967) using
        * the https://eth.wiki/json-rpc/API#eth_getstorageat[`eth_getStorageAt`] RPC call.
        * `0xb53127684a568b3173ae13b9f8a6016e243e63b6e8ee1178d6a717850b5d6103`
        */
        function getAdmin() internal view returns (address) {
            return StorageSlot.getAddressSlot(ADMIN_SLOT).value;
        }

        /**
        * @dev Stores a new address in the EIP1967 admin slot.
        */
        function _setAdmin(address newAdmin) private {
            if (newAdmin == address(0)) {
                revert ERC1967InvalidAdmin(address(0));
            }
            StorageSlot.getAddressSlot(ADMIN_SLOT).value = newAdmin;
        }

        /**
        * @dev Changes the admin of the proxy.
        *
        * Emits an {IERC1967-AdminChanged} event.
        */
        function changeAdmin(address newAdmin) internal {
            emit AdminChanged(getAdmin(), newAdmin);
            _setAdmin(newAdmin);
        }

        /**
        * @dev The storage slot of the UpgradeableBeacon contract which defines the implementation for this proxy.
        * This is the keccak-256 hash of "eip1967.proxy.beacon" subtracted by 1.
        */
        // solhint-disable-next-line private-vars-leading-underscore
        bytes32 internal constant BEACON_SLOT = 0xa3f0ad74e5423aebfd80d3ef4346578335a9a72aeaee59ff6cb3582b35133d50;

        /**
        * @dev Returns the current beacon.
        */
        function getBeacon() internal view returns (address) {
            return StorageSlot.getAddressSlot(BEACON_SLOT).value;
        }

        /**
        * @dev Stores a new beacon in the EIP1967 beacon slot.
        */
        function _setBeacon(address newBeacon) private {
            if (newBeacon.code.length == 0) {
                revert ERC1967InvalidBeacon(newBeacon);
            }

            StorageSlot.getAddressSlot(BEACON_SLOT).value = newBeacon;

            address beaconImplementation = IBeacon(newBeacon).implementation();
            if (beaconImplementation.code.length == 0) {
                revert ERC1967InvalidImplementation(beaconImplementation);
            }
        }

        /**
        * @dev Change the beacon and trigger a setup call if data is nonempty.
        * This function is payable only if the setup call is performed, otherwise `msg.value` is rejected
        * to avoid stuck value in the contract.
        *
        * Emits an {IERC1967-BeaconUpgraded} event.
        *
        * CAUTION: Invoking this function has no effect on an instance of {BeaconProxy} since v5, since
        * it uses an immutable beacon without looking at the value of the ERC-1967 beacon slot for
        * efficiency.
        */
        function upgradeBeaconToAndCall(address newBeacon, bytes memory data) internal {
            _setBeacon(newBeacon);
            emit BeaconUpgraded(newBeacon);

            if (data.length > 0) {
                Address.functionDelegateCall(IBeacon(newBeacon).implementation(), data);
            } else {
                _checkNonPayable();
            }
        }

        /**
        * @dev Reverts if `msg.value` is not zero. It can be used to avoid `msg.value` stuck in the contract
        * if an upgrade doesn't perform an initialization call.
        */
        function _checkNonPayable() private {
            if (msg.value > 0) {
                revert ERC1967NonPayable();
            }
        }
    }


    // File @openzeppelin/contracts-upgradeable/proxy/utils/UUPSUpgradeable.sol@v5.0.2

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (proxy/utils/UUPSUpgradeable.sol)

    //pragma solidity ^0.8.20;



    /**
    * @dev An upgradeability mechanism designed for UUPS proxies. The functions included here can perform an upgrade of an
    * {ERC1967Proxy}, when this contract is set as the implementation behind such a proxy.
    *
    * A security mechanism ensures that an upgrade does not turn off upgradeability accidentally, although this risk is
    * reinstated if the upgrade retains upgradeability but removes the security mechanism, e.g. by replacing
    * `UUPSUpgradeable` with a custom implementation of upgrades.
    *
    * The {_authorizeUpgrade} function must be overridden to include access restriction to the upgrade mechanism.
    */
    abstract contract UUPSUpgradeable is Initializable, IERC1822Proxiable {
        /// @custom:oz-upgrades-unsafe-allow state-variable-immutable
        address private immutable __self = address(this);

        /**
        * @dev The version of the upgrade interface of the contract. If this getter is missing, both `upgradeTo(address)`
        * and `upgradeToAndCall(address,bytes)` are present, and `upgradeTo` must be used if no function should be called,
        * while `upgradeToAndCall` will invoke the `receive` function if the second argument is the empty byte string.
        * If the getter returns `"5.0.0"`, only `upgradeToAndCall(address,bytes)` is present, and the second argument must
        * be the empty byte string if no function should be called, making it impossible to invoke the `receive` function
        * during an upgrade.
        */
        string public constant UPGRADE_INTERFACE_VERSION = "5.0.0";

        /**
        * @dev The call is from an unauthorized context.
        */
        error UUPSUnauthorizedCallContext();

        /**
        * @dev The storage `slot` is unsupported as a UUID.
        */
        error UUPSUnsupportedProxiableUUID(bytes32 slot);

        /**
        * @dev Check that the execution is being performed through a delegatecall call and that the execution context is
        * a proxy contract with an implementation (as defined in ERC1967) pointing to self. This should only be the case
        * for UUPS and transparent proxies that are using the current contract as their implementation. Execution of a
        * function through ERC1167 minimal proxies (clones) would not normally pass this test, but is not guaranteed to
        * fail.
        */
        modifier onlyProxy() {
            _checkProxy();
            _;
        }

        /**
        * @dev Check that the execution is not being performed through a delegate call. This allows a function to be
        * callable on the implementing contract but not through proxies.
        */
        modifier notDelegated() {
            _checkNotDelegated();
            _;
        }

        function __UUPSUpgradeable_init() internal onlyInitializing {
        }

        function __UUPSUpgradeable_init_unchained() internal onlyInitializing {
        }
        /**
        * @dev Implementation of the ERC1822 {proxiableUUID} function. This returns the storage slot used by the
        * implementation. It is used to validate the implementation's compatibility when performing an upgrade.
        *
        * IMPORTANT: A proxy pointing at a proxiable contract should not be considered proxiable itself, because this risks
        * bricking a proxy that upgrades to it, by delegating to itself until out of gas. Thus it is critical that this
        * function revert if invoked through a proxy. This is guaranteed by the `notDelegated` modifier.
        */
        function proxiableUUID() external view virtual notDelegated returns (bytes32) {
            return ERC1967Utils.IMPLEMENTATION_SLOT;
        }

        /**
        * @dev Upgrade the implementation of the proxy to `newImplementation`, and subsequently execute the function call
        * encoded in `data`.
        *
        * Calls {_authorizeUpgrade}.
        *
        * Emits an {Upgraded} event.
        *
        * @custom:oz-upgrades-unsafe-allow-reachable delegatecall
        */
        function upgradeToAndCall(address newImplementation, bytes memory data) public payable virtual onlyProxy {
            _authorizeUpgrade(newImplementation);
            _upgradeToAndCallUUPS(newImplementation, data);
        }

        /**
        * @dev Reverts if the execution is not performed via delegatecall or the execution
        * context is not of a proxy with an ERC1967-compliant implementation pointing to self.
        * See {_onlyProxy}.
        */
        function _checkProxy() internal view virtual {
            if (
                address(this) == __self || // Must be called through delegatecall
                ERC1967Utils.getImplementation() != __self // Must be called through an active proxy
            ) {
                revert UUPSUnauthorizedCallContext();
            }
        }

        /**
        * @dev Reverts if the execution is performed via delegatecall.
        * See {notDelegated}.
        */
        function _checkNotDelegated() internal view virtual {
            if (address(this) != __self) {
                // Must not be called through delegatecall
                revert UUPSUnauthorizedCallContext();
            }
        }

        /**
        * @dev Function that should revert when `msg.sender` is not authorized to upgrade the contract. Called by
        * {upgradeToAndCall}.
        *
        * Normally, this function will use an xref:access.adoc[access control] modifier such as {Ownable-onlyOwner}.
        *
        * ```solidity
        * function _authorizeUpgrade(address) internal onlyOwner {}
        * ```
        */
        function _authorizeUpgrade(address newImplementation) internal virtual;

        /**
        * @dev Performs an implementation upgrade with a security check for UUPS proxies, and additional setup call.
        *
        * As a security check, {proxiableUUID} is invoked in the new implementation, and the return value
        * is expected to be the implementation slot in ERC1967.
        *
        * Emits an {IERC1967-Upgraded} event.
        */
        function _upgradeToAndCallUUPS(address newImplementation, bytes memory data) private {
            try IERC1822Proxiable(newImplementation).proxiableUUID() returns (bytes32 slot) {
                if (slot != ERC1967Utils.IMPLEMENTATION_SLOT) {
                    revert UUPSUnsupportedProxiableUUID(slot);
                }
                ERC1967Utils.upgradeToAndCall(newImplementation, data);
            } catch {
                // The implementation is not UUPS
                revert ERC1967Utils.ERC1967InvalidImplementation(newImplementation);
            }
        }
    }


    // File @openzeppelin/contracts/interfaces/draft-IERC6093.sol@v5.0.2

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (interfaces/draft-IERC6093.sol)
    //pragma solidity ^0.8.20;

    /**
    * @dev Standard ERC20 Errors
    * Interface of the https://eips.ethereum.org/EIPS/eip-6093[ERC-6093] custom errors for ERC20 tokens.
    */
    interface IERC20Errors {
        /**
        * @dev Indicates an error related to the current `balance` of a `sender`. Used in transfers.
        * @param sender Address whose tokens are being transferred.
        * @param balance Current balance for the interacting account.
        * @param needed Minimum amount required to perform a transfer.
        */
        error ERC20InsufficientBalance(address sender, uint256 balance, uint256 needed);

        /**
        * @dev Indicates a failure with the token `sender`. Used in transfers.
        * @param sender Address whose tokens are being transferred.
        */
        error ERC20InvalidSender(address sender);

        /**
        * @dev Indicates a failure with the token `receiver`. Used in transfers.
        * @param receiver Address to which tokens are being transferred.
        */
        error ERC20InvalidReceiver(address receiver);

        /**
        * @dev Indicates a failure with the `spender`’s `allowance`. Used in transfers.
        * @param spender Address that may be allowed to operate on tokens without being their owner.
        * @param allowance Amount of tokens a `spender` is allowed to operate with.
        * @param needed Minimum amount required to perform a transfer.
        */
        error ERC20InsufficientAllowance(address spender, uint256 allowance, uint256 needed);

        /**
        * @dev Indicates a failure with the `approver` of a token to be approved. Used in approvals.
        * @param approver Address initiating an approval operation.
        */
        error ERC20InvalidApprover(address approver);

        /**
        * @dev Indicates a failure with the `spender` to be approved. Used in approvals.
        * @param spender Address that may be allowed to operate on tokens without being their owner.
        */
        error ERC20InvalidSpender(address spender);
    }

    /**
    * @dev Standard ERC721 Errors
    * Interface of the https://eips.ethereum.org/EIPS/eip-6093[ERC-6093] custom errors for ERC721 tokens.
    */
    interface IERC721Errors {
        /**
        * @dev Indicates that an address can't be an owner. For example, `address(0)` is a forbidden owner in EIP-20.
        * Used in balance queries.
        * @param owner Address of the current owner of a token.
        */
        error ERC721InvalidOwner(address owner);

        /**
        * @dev Indicates a `tokenId` whose `owner` is the zero address.
        * @param tokenId Identifier number of a token.
        */
        error ERC721NonexistentToken(uint256 tokenId);

        /**
        * @dev Indicates an error related to the ownership over a particular token. Used in transfers.
        * @param sender Address whose tokens are being transferred.
        * @param tokenId Identifier number of a token.
        * @param owner Address of the current owner of a token.
        */
        error ERC721IncorrectOwner(address sender, uint256 tokenId, address owner);

        /**
        * @dev Indicates a failure with the token `sender`. Used in transfers.
        * @param sender Address whose tokens are being transferred.
        */
        error ERC721InvalidSender(address sender);

        /**
        * @dev Indicates a failure with the token `receiver`. Used in transfers.
        * @param receiver Address to which tokens are being transferred.
        */
        error ERC721InvalidReceiver(address receiver);

        /**
        * @dev Indicates a failure with the `operator`’s approval. Used in transfers.
        * @param operator Address that may be allowed to operate on tokens without being their owner.
        * @param tokenId Identifier number of a token.
        */
        error ERC721InsufficientApproval(address operator, uint256 tokenId);

        /**
        * @dev Indicates a failure with the `approver` of a token to be approved. Used in approvals.
        * @param approver Address initiating an approval operation.
        */
        error ERC721InvalidApprover(address approver);

        /**
        * @dev Indicates a failure with the `operator` to be approved. Used in approvals.
        * @param operator Address that may be allowed to operate on tokens without being their owner.
        */
        error ERC721InvalidOperator(address operator);
    }

    /**
    * @dev Standard ERC1155 Errors
    * Interface of the https://eips.ethereum.org/EIPS/eip-6093[ERC-6093] custom errors for ERC1155 tokens.
    */
    interface IERC1155Errors {
        /**
        * @dev Indicates an error related to the current `balance` of a `sender`. Used in transfers.
        * @param sender Address whose tokens are being transferred.
        * @param balance Current balance for the interacting account.
        * @param needed Minimum amount required to perform a transfer.
        * @param tokenId Identifier number of a token.
        */
        error ERC1155InsufficientBalance(address sender, uint256 balance, uint256 needed, uint256 tokenId);

        /**
        * @dev Indicates a failure with the token `sender`. Used in transfers.
        * @param sender Address whose tokens are being transferred.
        */
        error ERC1155InvalidSender(address sender);

        /**
        * @dev Indicates a failure with the token `receiver`. Used in transfers.
        * @param receiver Address to which tokens are being transferred.
        */
        error ERC1155InvalidReceiver(address receiver);

        /**
        * @dev Indicates a failure with the `operator`’s approval. Used in transfers.
        * @param operator Address that may be allowed to operate on tokens without being their owner.
        * @param owner Address of the current owner of a token.
        */
        error ERC1155MissingApprovalForAll(address operator, address owner);

        /**
        * @dev Indicates a failure with the `approver` of a token to be approved. Used in approvals.
        * @param approver Address initiating an approval operation.
        */
        error ERC1155InvalidApprover(address approver);

        /**
        * @dev Indicates a failure with the `operator` to be approved. Used in approvals.
        * @param operator Address that may be allowed to operate on tokens without being their owner.
        */
        error ERC1155InvalidOperator(address operator);

        /**
        * @dev Indicates an array length mismatch between ids and values in a safeBatchTransferFrom operation.
        * Used in batch transfers.
        * @param idsLength Length of the array of token identifiers
        * @param valuesLength Length of the array of token amounts
        */
        error ERC1155InvalidArrayLength(uint256 idsLength, uint256 valuesLength);
    }


    // File @openzeppelin/contracts/token/ERC20/IERC20.sol@v5.0.2

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (token/ERC20/IERC20.sol)

    //pragma solidity ^0.8.20;

    /**
    * @dev Interface of the ERC20 standard as defined in the EIP.
    */
    interface IERC20 {
        /**
        * @dev Emitted when `value` tokens are moved from one account (`from`) to
        * another (`to`).
        *
        * Note that `value` may be zero.
        */
        event Transfer(address indexed from, address indexed to, uint256 value);

        /**
        * @dev Emitted when the allowance of a `spender` for an `owner` is set by
        * a call to {approve}. `value` is the new allowance.
        */
        event Approval(address indexed owner, address indexed spender, uint256 value);

        /**
        * @dev Returns the value of tokens in existence.
        */
        function totalSupply() external view returns (uint256);

        /**
        * @dev Returns the value of tokens owned by `account`.
        */
        function balanceOf(address account) external view returns (uint256);

        /**
        * @dev Moves a `value` amount of tokens from the caller's account to `to`.
        *
        * Returns a boolean value indicating whether the operation succeeded.
        *
        * Emits a {Transfer} event.
        */
        function transfer(address to, uint256 value) external returns (bool);

        /**
        * @dev Returns the remaining number of tokens that `spender` will be
        * allowed to spend on behalf of `owner` through {transferFrom}. This is
        * zero by default.
        *
        * This value changes when {approve} or {transferFrom} are called.
        */
        function allowance(address owner, address spender) external view returns (uint256);

        /**
        * @dev Sets a `value` amount of tokens as the allowance of `spender` over the
        * caller's tokens.
        *
        * Returns a boolean value indicating whether the operation succeeded.
        *
        * IMPORTANT: Beware that changing an allowance with this method brings the risk
        * that someone may use both the old and the new allowance by unfortunate
        * transaction ordering. One possible solution to mitigate this race
        * condition is to first reduce the spender's allowance to 0 and set the
        * desired value afterwards:
        * https://github.com/ethereum/EIPs/issues/20#issuecomment-263524729
        *
        * Emits an {Approval} event.
        */
        function approve(address spender, uint256 value) external returns (bool);

        /**
        * @dev Moves a `value` amount of tokens from `from` to `to` using the
        * allowance mechanism. `value` is then deducted from the caller's
        * allowance.
        *
        * Returns a boolean value indicating whether the operation succeeded.
        *
        * Emits a {Transfer} event.
        */
        function transferFrom(address from, address to, uint256 value) external returns (bool);
    }


    // File @openzeppelin/contracts/token/ERC20/extensions/IERC20Metadata.sol@v5.0.2

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (token/ERC20/extensions/IERC20Metadata.sol)

    //pragma solidity ^0.8.20;

    /**
    * @dev Interface for the optional metadata functions from the ERC20 standard.
    */
    interface IERC20Metadata is IERC20 {
        /**
        * @dev Returns the name of the token.
        */
        function name() external view returns (string memory);

        /**
        * @dev Returns the symbol of the token.
        */
        function symbol() external view returns (string memory);

        /**
        * @dev Returns the decimals places of the token.
        */
        function decimals() external view returns (uint8);
    }


    // File @openzeppelin/contracts-upgradeable/token/ERC20/ERC20Upgradeable.sol@v5.0.2

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (token/ERC20/ERC20.sol)

    //pragma solidity ^0.8.20;





    /**
    * @dev Implementation of the {IERC20} interface.
    *
    * This implementation is agnostic to the way tokens are created. This means
    * that a supply mechanism has to be added in a derived contract using {_mint}.
    *
    * TIP: For a detailed writeup see our guide
    * https://forum.openzeppelin.com/t/how-to-implement-erc20-supply-mechanisms/226[How
    * to implement supply mechanisms].
    *
    * The default value of {decimals} is 18. To change this, you should override
    * this function so it returns a different value.
    *
    * We have followed general OpenZeppelin Contracts guidelines: functions revert
    * instead returning `false` on failure. This behavior is nonetheless
    * conventional and does not conflict with the expectations of ERC20
    * applications.
    *
    * Additionally, an {Approval} event is emitted on calls to {transferFrom}.
    * This allows applications to reconstruct the allowance for all accounts just
    * by listening to said events. Other implementations of the EIP may not emit
    * these events, as it isn't required by the specification.
    */
    abstract contract ERC20Upgradeable is Initializable, ContextUpgradeable, IERC20, IERC20Metadata, IERC20Errors {
        /// @custom:storage-location erc7201:openzeppelin.storage.ERC20
        struct ERC20Storage {
            mapping(address account => uint256) _balances;

            mapping(address account => mapping(address spender => uint256)) _allowances;

            uint256 _totalSupply;

            string _name;
            string _symbol;
        }

        // keccak256(abi.encode(uint256(keccak256("openzeppelin.storage.ERC20")) - 1)) & ~bytes32(uint256(0xff))
        bytes32 private constant ERC20StorageLocation = 0x52c63247e1f47db19d5ce0460030c497f067ca4cebf71ba98eeadabe20bace00;

        function _getERC20Storage() private pure returns (ERC20Storage storage $) {
            assembly {
                $.slot := ERC20StorageLocation
            }
        }

        /**
        * @dev Sets the values for {name} and {symbol}.
        *
        * All two of these values are immutable: they can only be set once during
        * construction.
        */
        function __ERC20_init(string memory name_, string memory symbol_) internal onlyInitializing {
            __ERC20_init_unchained(name_, symbol_);
        }

        function __ERC20_init_unchained(string memory name_, string memory symbol_) internal onlyInitializing {
            ERC20Storage storage $ = _getERC20Storage();
            $._name = name_;
            $._symbol = symbol_;
        }

        /**
        * @dev Returns the name of the token.
        */
        function name() public view virtual returns (string memory) {
            ERC20Storage storage $ = _getERC20Storage();
            return $._name;
        }

        /**
        * @dev Returns the symbol of the token, usually a shorter version of the
        * name.
        */
        function symbol() public view virtual returns (string memory) {
            ERC20Storage storage $ = _getERC20Storage();
            return $._symbol;
        }

        /**
        * @dev Returns the number of decimals used to get its user representation.
        * For example, if `decimals` equals `2`, a balance of `505` tokens should
        * be displayed to a user as `5.05` (`505 / 10 ** 2`).
        *
        * Tokens usually opt for a value of 18, imitating the relationship between
        * Ether and Wei. This is the default value returned by this function, unless
        * it's overridden.
        *
        * NOTE: This information is only used for _display_ purposes: it in
        * no way affects any of the arithmetic of the contract, including
        * {IERC20-balanceOf} and {IERC20-transfer}.
        */
        function decimals() public view virtual returns (uint8) {
            return 18;
        }

        /**
        * @dev See {IERC20-totalSupply}.
        */
        function totalSupply() public view virtual returns (uint256) {
            ERC20Storage storage $ = _getERC20Storage();
            return $._totalSupply;
        }

        /**
        * @dev See {IERC20-balanceOf}.
        */
        function balanceOf(address account) public view virtual returns (uint256) {
            ERC20Storage storage $ = _getERC20Storage();
            return $._balances[account];
        }

        /**
        * @dev See {IERC20-transfer}.
        *
        * Requirements:
        *
        * - `to` cannot be the zero address.
        * - the caller must have a balance of at least `value`.
        */
        function transfer(address to, uint256 value) public virtual returns (bool) {
            address owner = _msgSender();
            _transfer(owner, to, value);
            return true;
        }

        /**
        * @dev See {IERC20-allowance}.
        */
        function allowance(address owner, address spender) public view virtual returns (uint256) {
            ERC20Storage storage $ = _getERC20Storage();
            return $._allowances[owner][spender];
        }

        /**
        * @dev See {IERC20-approve}.
        *
        * NOTE: If `value` is the maximum `uint256`, the allowance is not updated on
        * `transferFrom`. This is semantically equivalent to an infinite approval.
        *
        * Requirements:
        *
        * - `spender` cannot be the zero address.
        */
        function approve(address spender, uint256 value) public virtual returns (bool) {
            address owner = _msgSender();
            _approve(owner, spender, value);
            return true;
        }

        /**
        * @dev See {IERC20-transferFrom}.
        *
        * Emits an {Approval} event indicating the updated allowance. This is not
        * required by the EIP. See the note at the beginning of {ERC20}.
        *
        * NOTE: Does not update the allowance if the current allowance
        * is the maximum `uint256`.
        *
        * Requirements:
        *
        * - `from` and `to` cannot be the zero address.
        * - `from` must have a balance of at least `value`.
        * - the caller must have allowance for ``from``'s tokens of at least
        * `value`.
        */
        function transferFrom(address from, address to, uint256 value) public virtual returns (bool) {
            address spender = _msgSender();
            _spendAllowance(from, spender, value);
            _transfer(from, to, value);
            return true;
        }

        /**
        * @dev Moves a `value` amount of tokens from `from` to `to`.
        *
        * This internal function is equivalent to {transfer}, and can be used to
        * e.g. implement automatic token fees, slashing mechanisms, etc.
        *
        * Emits a {Transfer} event.
        *
        * NOTE: This function is not virtual, {_update} should be overridden instead.
        */
        function _transfer(address from, address to, uint256 value) internal {
            if (from == address(0)) {
                revert ERC20InvalidSender(address(0));
            }
            if (to == address(0)) {
                revert ERC20InvalidReceiver(address(0));
            }
            _update(from, to, value);
        }

        /**
        * @dev Transfers a `value` amount of tokens from `from` to `to`, or alternatively mints (or burns) if `from`
        * (or `to`) is the zero address. All customizations to transfers, mints, and burns should be done by overriding
        * this function.
        *
        * Emits a {Transfer} event.
        */
        function _update(address from, address to, uint256 value) internal virtual {
            ERC20Storage storage $ = _getERC20Storage();
            if (from == address(0)) {
                // Overflow check required: The rest of the code assumes that totalSupply never overflows
                $._totalSupply += value;
            } else {
                uint256 fromBalance = $._balances[from];
                if (fromBalance < value) {
                    revert ERC20InsufficientBalance(from, fromBalance, value);
                }
                unchecked {
                    // Overflow not possible: value <= fromBalance <= totalSupply.
                    $._balances[from] = fromBalance - value;
                }
            }

            if (to == address(0)) {
                unchecked {
                    // Overflow not possible: value <= totalSupply or value <= fromBalance <= totalSupply.
                    $._totalSupply -= value;
                }
            } else {
                unchecked {
                    // Overflow not possible: balance + value is at most totalSupply, which we know fits into a uint256.
                    $._balances[to] += value;
                }
            }

            emit Transfer(from, to, value);
        }

        /**
        * @dev Creates a `value` amount of tokens and assigns them to `account`, by transferring it from address(0).
        * Relies on the `_update` mechanism
        *
        * Emits a {Transfer} event with `from` set to the zero address.
        *
        * NOTE: This function is not virtual, {_update} should be overridden instead.
        */
        function _mint(address account, uint256 value) internal {
            if (account == address(0)) {
                revert ERC20InvalidReceiver(address(0));
            }
            _update(address(0), account, value);
        }

        /**
        * @dev Destroys a `value` amount of tokens from `account`, lowering the total supply.
        * Relies on the `_update` mechanism.
        *
        * Emits a {Transfer} event with `to` set to the zero address.
        *
        * NOTE: This function is not virtual, {_update} should be overridden instead
        */
        function _burn(address account, uint256 value) internal {
            if (account == address(0)) {
                revert ERC20InvalidSender(address(0));
            }
            _update(account, address(0), value);
        }

        /**
        * @dev Sets `value` as the allowance of `spender` over the `owner` s tokens.
        *
        * This internal function is equivalent to `approve`, and can be used to
        * e.g. set automatic allowances for certain subsystems, etc.
        *
        * Emits an {Approval} event.
        *
        * Requirements:
        *
        * - `owner` cannot be the zero address.
        * - `spender` cannot be the zero address.
        *
        * Overrides to this logic should be done to the variant with an additional `bool emitEvent` argument.
        */
        function _approve(address owner, address spender, uint256 value) internal {
            _approve(owner, spender, value, true);
        }

        /**
        * @dev Variant of {_approve} with an optional flag to enable or disable the {Approval} event.
        *
        * By default (when calling {_approve}) the flag is set to true. On the other hand, approval changes made by
        * `_spendAllowance` during the `transferFrom` operation set the flag to false. This saves gas by not emitting any
        * `Approval` event during `transferFrom` operations.
        *
        * Anyone who wishes to continue emitting `Approval` events on the`transferFrom` operation can force the flag to
        * true using the following override:
        * ```
        * function _approve(address owner, address spender, uint256 value, bool) internal virtual override {
        *     super._approve(owner, spender, value, true);
        * }
        * ```
        *
        * Requirements are the same as {_approve}.
        */
        function _approve(address owner, address spender, uint256 value, bool emitEvent) internal virtual {
            ERC20Storage storage $ = _getERC20Storage();
            if (owner == address(0)) {
                revert ERC20InvalidApprover(address(0));
            }
            if (spender == address(0)) {
                revert ERC20InvalidSpender(address(0));
            }
            $._allowances[owner][spender] = value;
            if (emitEvent) {
                emit Approval(owner, spender, value);
            }
        }

        /**
        * @dev Updates `owner` s allowance for `spender` based on spent `value`.
        *
        * Does not update the allowance value in case of infinite allowance.
        * Revert if not enough allowance is available.
        *
        * Does not emit an {Approval} event.
        */
        function _spendAllowance(address owner, address spender, uint256 value) internal virtual {
            uint256 currentAllowance = allowance(owner, spender);
            if (currentAllowance != type(uint256).max) {
                if (currentAllowance < value) {
                    revert ERC20InsufficientAllowance(spender, currentAllowance, value);
                }
                unchecked {
                    _approve(owner, spender, currentAllowance - value, false);
                }
            }
        }
    }


    // File @openzeppelin/contracts-upgradeable/utils/PausableUpgradeable.sol@v5.0.2

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (utils/Pausable.sol)

    //pragma solidity ^0.8.20;


    /**
    * @dev Contract module which allows children to implement an emergency stop
    * mechanism that can be triggered by an authorized account.
    *
    * This module is used through inheritance. It will make available the
    * modifiers `whenNotPaused` and `whenPaused`, which can be applied to
    * the functions of your contract. Note that they will not be pausable by
    * simply including this module, only once the modifiers are put in place.
    */
    abstract contract PausableUpgradeable is Initializable, ContextUpgradeable {
        /// @custom:storage-location erc7201:openzeppelin.storage.Pausable
        struct PausableStorage {
            bool _paused;
        }

        // keccak256(abi.encode(uint256(keccak256("openzeppelin.storage.Pausable")) - 1)) & ~bytes32(uint256(0xff))
        bytes32 private constant PausableStorageLocation = 0xcd5ed15c6e187e77e9aee88184c21f4f2182ab5827cb3b7e07fbedcd63f03300;

        function _getPausableStorage() private pure returns (PausableStorage storage $) {
            assembly {
                $.slot := PausableStorageLocation
            }
        }

        /**
        * @dev Emitted when the pause is triggered by `account`.
        */
        event Paused(address account);

        /**
        * @dev Emitted when the pause is lifted by `account`.
        */
        event Unpaused(address account);

        /**
        * @dev The operation failed because the contract is paused.
        */
        error EnforcedPause();

        /**
        * @dev The operation failed because the contract is not paused.
        */
        error ExpectedPause();

        /**
        * @dev Initializes the contract in unpaused state.
        */
        function __Pausable_init() internal onlyInitializing {
            __Pausable_init_unchained();
        }

        function __Pausable_init_unchained() internal onlyInitializing {
            PausableStorage storage $ = _getPausableStorage();
            $._paused = false;
        }

        /**
        * @dev Modifier to make a function callable only when the contract is not paused.
        *
        * Requirements:
        *
        * - The contract must not be paused.
        */
        modifier whenNotPaused() {
            _requireNotPaused();
            _;
        }

        /**
        * @dev Modifier to make a function callable only when the contract is paused.
        *
        * Requirements:
        *
        * - The contract must be paused.
        */
        modifier whenPaused() {
            _requirePaused();
            _;
        }

        /**
        * @dev Returns true if the contract is paused, and false otherwise.
        */
        function paused() public view virtual returns (bool) {
            PausableStorage storage $ = _getPausableStorage();
            return $._paused;
        }

        /**
        * @dev Throws if the contract is paused.
        */
        function _requireNotPaused() internal view virtual {
            if (paused()) {
                revert EnforcedPause();
            }
        }

        /**
        * @dev Throws if the contract is not paused.
        */
        function _requirePaused() internal view virtual {
            if (!paused()) {
                revert ExpectedPause();
            }
        }

        /**
        * @dev Triggers stopped state.
        *
        * Requirements:
        *
        * - The contract must not be paused.
        */
        function _pause() internal virtual whenNotPaused {
            PausableStorage storage $ = _getPausableStorage();
            $._paused = true;
            emit Paused(_msgSender());
        }

        /**
        * @dev Returns to normal state.
        *
        * Requirements:
        *
        * - The contract must be paused.
        */
        function _unpause() internal virtual whenPaused {
            PausableStorage storage $ = _getPausableStorage();
            $._paused = false;
            emit Unpaused(_msgSender());
        }
    }


    // File @openzeppelin/contracts-upgradeable/token/ERC20/extensions/ERC20PausableUpgradeable.sol@v5.0.2

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (token/ERC20/extensions/ERC20Pausable.sol)

    //pragma solidity ^0.8.20;



    /**
    * @dev ERC20 token with pausable token transfers, minting and burning.
    *
    * Useful for scenarios such as preventing trades until the end of an evaluation
    * period, or having an emergency switch for freezing all token transfers in the
    * event of a large bug.
    *
    * IMPORTANT: This contract does not include public pause and unpause functions. In
    * addition to inheriting this contract, you must define both functions, invoking the
    * {Pausable-_pause} and {Pausable-_unpause} internal functions, with appropriate
    * access control, e.g. using {AccessControl} or {Ownable}. Not doing so will
    * make the contract pause mechanism of the contract unreachable, and thus unusable.
    */
    abstract contract ERC20PausableUpgradeable is Initializable, ERC20Upgradeable, PausableUpgradeable {
        function __ERC20Pausable_init() internal onlyInitializing {
            __Pausable_init_unchained();
        }

        function __ERC20Pausable_init_unchained() internal onlyInitializing {
        }
        /**
        * @dev See {ERC20-_update}.
        *
        * Requirements:
        *
        * - the contract must not be paused.
        */
        function _update(address from, address to, uint256 value) internal virtual override whenNotPaused {
            super._update(from, to, value);
        }
    }


    // File lib/ERC1066.sol

    // Original license: SPDX_License_Identifier: MIT
    //pragma solidity ^0.8.9;

    
    /// @custom:security-contact soporte@comunyt.com
    contract ERC1066 {

        // Uses status codes from ERC-1066
        bytes1 internal  constant STATUS_DISALLOWED = 0x10;   // 0001 0000
        bytes1 internal  constant STATUS_ALLOWED = 0x11;      // 0001 0001
        bytes1 internal  constant STATUS_INSUFICIENTFUNDS = 0x54 ;
        bytes1 internal  constant STATUS_TRANSFERVOLUMEEXCEEDED = 0x56 ;

        /// @dev ERC-1066 status codes encoded as human-readable enums
        enum Status {

            // 0x0*
            Failure,
            Success,
            AwatingOthers,
            Accepted,
            LowerLimit,
            RecieverActionRequested,
            UpperLimit,
            RESERVEDx07,
            Inapplicable,
            RESERVEDx09,
            RESERVEDx0A,
            RESERVEDx0B,
            RESERVEDx0C,
            RESERVEDx0D,
            RESERVEDx0E,
            Informational,

            // 0x1*
            Disallowed_Stop,
            Allowed_Go,
            AwaitingOthersPermission,
            PermissionRequested,
            TooOpen_Insecure,
            NeedsYourPermission_RequestForContinuation,
            Revoked_Banned,
            RESERVEDx17,
            NotApplicatableToCurrentState,
            RESERVEDx19,
            RESERVEDx1A,
            RESERVEDx1B,
            RESERVEDx1C,
            RESERVEDx1D,
            RESERVEDx1E,
            PermissionDetails_ControlConditions,

            // 0x2*
            NotFound_Unequal_OutOfRange,
            Found_Equal_InRange,
            AwaitingMatch,
            MatchRequestSent,
            BelowRange_Underflow,
            RequestForMatch,
            Above_Range_Overflow,
            RESERVEDx27,
            Duplicate_Conflict_Collision,
            RESERVEDx29,
            RESERVEDx2A,
            RESERVEDx2B,
            RESERVEDx2C,
            RESERVEDx2D,
            RESERVEDx2E,
            MatchingInformation,

            // 0x3*
            SenderDisagrees_Nay,
            SenderAgrees_Yea,
            AwaitingRatification,
            OfferSent_Voted,
            QuorumNotReached,
            ReceiversRatificationRequested,
            OfferOrVoteLimitReached,
            RESERVEDx37,
            AlreadyVoted,
            RESERVEDx39,
            RESERVEDx3A,
            RESERVEDx3B,
            RESERVEDx3C,
            RESERVEDx3D,
            RESERVEDx3E,
            NegotiationRules_ParticipationInformation,

            // 0x4*
            Unavailable,
            Available,
            Paused,
            Queued,
            NotAvailableYet,
            AwaitingYourAvailability,
            Expired,
            RESERVEDx47,
            AlreadyDone,
            RESERVEDx49,
            RESERVEDx4A,
            RESERVEDx4B,
            RESERVEDx4C,
            RESERVEDx4D,
            RESERVEDx4E,
            AvailabilityRules_Information,

            // 0x5*
            TransferFailed,
            TransferSuccessful,
            AwaitingPaymentFromOthers,
            Hold_Escrow,
            InsufficientFunds,
            FundsRequested,
            TransferVolumeExceeded,
            RESERVEDx57,
            FundsNotRequired,
            RESERVEDx59,
            RESERVEDx5A,
            RESERVEDx5B,
            RESERVEDx5C,
            RESERVEDx5D,
            RESERVEDx5E,
            FinancialInformation,

            // 0x6*
            RESERVEDx60,
            RESERVEDx61,
            RESERVEDx62,
            RESERVEDx63,
            RESERVEDx64,
            RESERVEDx65,
            RESERVEDx66,
            RESERVEDx67,
            RESERVEDx68,
            RESERVEDx69,
            RESERVEDx6A,
            RESERVEDx6B,
            RESERVEDx6C,
            RESERVEDx6D,
            RESERVEDx6E,
            RESERVEDx6F,

            // 0x7*
            RESERVEDx70,
            RESERVEDx71,
            RESERVEDx72,
            RESERVEDx73,
            RESERVEDx74,
            RESERVEDx75,
            RESERVEDx76,
            RESERVEDx77,
            RESERVEDx78,
            RESERVEDx79,
            RESERVEDx7A,
            RESERVEDx7B,
            RESERVEDx7C,
            RESERVEDx7D,
            RESERVEDx7E,
            RESERVEDx7F,

            // 0x8*
            RESERVEDx80,
            RESERVEDx81,
            RESERVEDx82,
            RESERVEDx83,
            RESERVEDx84,
            RESERVEDx85,
            RESERVEDx86,
            RESERVEDx87,
            RESERVEDx88,
            RESERVEDx89,
            RESERVEDx8A,
            RESERVEDx8B,
            RESERVEDx8C,
            RESERVEDx8D,
            RESERVEDx8E,
            RESERVEDx8F,

            // 0x9*
            RESERVEDx90,
            RESERVEDx91,
            RESERVEDx92,
            RESERVEDx93,
            RESERVEDx94,
            RESERVEDx95,
            RESERVEDx96,
            RESERVEDx97,
            RESERVEDx98,
            RESERVEDx99,
            RESERVEDx9A,
            RESERVEDx9B,
            RESERVEDx9C,
            RESERVEDx9D,
            RESERVEDx9E,
            RESERVEDx9F,

            // 0xA*
            ApplicationSpecificFailure,
            ApplicationSpecificSuccess,
            ApplicationSpecificAwatingOthers,
            ApplicationSpecificAccepted,
            ApplicationSpecificLowerLimit,
            ApplicationSpecificRecieverActionRequested,
            ApplicationSpecificUpperLimit,
            RESERVEDxA7,
            ApplicationSpecific_Inapplicable,
            RESERVEDxA9,
            RESERVEDxAA,
            RESERVEDxAB,
            RESERVEDxAC,
            RESERVEDxAD,
            RESERVEDxAE,
            ApplicationSpecificInformational,

            // 0xB*
            RESERVEDxB0,
            RESERVEDxB1,
            RESERVEDxB2,
            RESERVEDxB3,
            RESERVEDxB4,
            RESERVEDxB5,
            RESERVEDxB6,
            RESERVEDxB7,
            RESERVEDxB8,
            RESERVEDxB9,
            RESERVEDxBA,
            RESERVEDxBB,
            RESERVEDxBC,
            RESERVEDxBD,
            RESERVEDxBE,
            RESERVEDxBF,

            // 0xC*
            RESERVEDxC0,
            RESERVEDxC1,
            RESERVEDxC2,
            RESERVEDxC3,
            RESERVEDxC4,
            RESERVEDxC5,
            RESERVEDxC6,
            RESERVEDxC7,
            RESERVEDxC8,
            RESERVEDxC9,
            RESERVEDxCA,
            RESERVEDxCB,
            RESERVEDxCC,
            RESERVEDxCD,
            RESERVEDxCE,
            RESERVEDxCF,

            // 0xD*
            RESERVEDxD0,
            RESERVEDxD1,
            RESERVEDxD2,
            RESERVEDxD3,
            RESERVEDxD4,
            RESERVEDxD5,
            RESERVEDxD6,
            RESERVEDxD7,
            RESERVEDxD8,
            RESERVEDxD9,
            RESERVEDxDA,
            RESERVEDxDB,
            RESERVEDxDC,
            RESERVEDxDD,
            RESERVEDxDE,
            RESERVEDxDF,

            // 0xE*
            DecryptFailure,
            DecryptSuccess,
            AwaitingOtherSignaturesOrKeys,
            Signed,
            Unsigned_Untrusted,
            SignatureRequired,
            KnownToBeCompromised,
            RESERVEDxE7,
            AlreadySigned_NotEncrypted,
            RESERVEDxE9,
            RESERVEDxEA,
            RESERVEDxEB,
            RESERVEDxEC,
            RESERVEDxED,
            RESERVEDxEE,
            Cryptography_ID_ProofMetadata,

            // 0xF*
            OffChainFailure,
            OffChainSuccess,
            AwatingOffChainProcess,
            OffChainProcessStarted,
            OffChainServiceUnreachable,
            OffChainActionRequired,
            OffChainExpiry_LimitReached,
            RESERVEDxF7,
            DuplicateOffChainRequest,
            RESERVEDxF9,
            RESERVEDxFA,
            RESERVEDxFB,
            RESERVEDxFC,
            RESERVEDxFD,
            RESERVEDxFE,
            OffChainInformation
        }
    }


    // File lib/utility.sol

    // Original license: SPDX_License_Identifier: MIT
    //pragma solidity ^0.8.20;
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


    // File openzeppelin-contracts/contracts/utils/cryptography/ECDSA.sol

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (utils/cryptography/ECDSA.sol)

    //pragma solidity ^0.8.20;

    /**
    * @dev Elliptic Curve Digital Signature Algorithm (ECDSA) operations.
    *
    * These functions can be used to verify that a message was signed by the holder
    * of the private keys of a given address.
    */
    library ECDSA {
        enum RecoverError {
            NoError,
            InvalidSignature,
            InvalidSignatureLength,
            InvalidSignatureS
        }

        /**
        * @dev The signature derives the `address(0)`.
        */
        error ECDSAInvalidSignature();

        /**
        * @dev The signature has an invalid length.
        */
        error ECDSAInvalidSignatureLength(uint256 length);

        /**
        * @dev The signature has an S value that is in the upper half order.
        */
        error ECDSAInvalidSignatureS(bytes32 s);

        /**
        * @dev Returns the address that signed a hashed message (`hash`) with `signature` or an error. This will not
        * return address(0) without also returning an error description. Errors are documented using an enum (error type)
        * and a bytes32 providing additional information about the error.
        *
        * If no error is returned, then the address can be used for verification purposes.
        *
        * The `ecrecover` EVM precompile allows for malleable (non-unique) signatures:
        * this function rejects them by requiring the `s` value to be in the lower
        * half order, and the `v` value to be either 27 or 28.
        *
        * IMPORTANT: `hash` _must_ be the result of a hash operation for the
        * verification to be secure: it is possible to craft signatures that
        * recover to arbitrary addresses for non-hashed data. A safe way to ensure
        * this is by receiving a hash of the original message (which may otherwise
        * be too long), and then calling {MessageHashUtils-toEthSignedMessageHash} on it.
        *
        * Documentation for signature generation:
        * - with https://web3js.readthedocs.io/en/v1.3.4/web3-eth-accounts.html#sign[Web3.js]
        * - with https://docs.ethers.io/v5/api/signer/#Signer-signMessage[ethers]
        */
        function tryRecover(bytes32 hash, bytes memory signature) internal pure returns (address, RecoverError, bytes32) {
            if (signature.length == 65) {
                bytes32 r;
                bytes32 s;
                uint8 v;
                // ecrecover takes the signature parameters, and the only way to get them
                // currently is to use assembly.
                /// @solidity memory-safe-assembly
                assembly {
                    r := mload(add(signature, 0x20))
                    s := mload(add(signature, 0x40))
                    v := byte(0, mload(add(signature, 0x60)))
                }
                return tryRecover(hash, v, r, s);
            } else {
                return (address(0), RecoverError.InvalidSignatureLength, bytes32(signature.length));
            }
        }

        /**
        * @dev Returns the address that signed a hashed message (`hash`) with
        * `signature`. This address can then be used for verification purposes.
        *
        * The `ecrecover` EVM precompile allows for malleable (non-unique) signatures:
        * this function rejects them by requiring the `s` value to be in the lower
        * half order, and the `v` value to be either 27 or 28.
        *
        * IMPORTANT: `hash` _must_ be the result of a hash operation for the
        * verification to be secure: it is possible to craft signatures that
        * recover to arbitrary addresses for non-hashed data. A safe way to ensure
        * this is by receiving a hash of the original message (which may otherwise
        * be too long), and then calling {MessageHashUtils-toEthSignedMessageHash} on it.
        */
        function recover(bytes32 hash, bytes memory signature) internal pure returns (address) {
            (address recovered, RecoverError error, bytes32 errorArg) = tryRecover(hash, signature);
            _throwError(error, errorArg);
            return recovered;
        }

        /**
        * @dev Overload of {ECDSA-tryRecover} that receives the `r` and `vs` short-signature fields separately.
        *
        * See https://eips.ethereum.org/EIPS/eip-2098[ERC-2098 short signatures]
        */
        function tryRecover(bytes32 hash, bytes32 r, bytes32 vs) internal pure returns (address, RecoverError, bytes32) {
            unchecked {
                bytes32 s = vs & bytes32(0x7fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff);
                // We do not check for an overflow here since the shift operation results in 0 or 1.
                uint8 v = uint8((uint256(vs) >> 255) + 27);
                return tryRecover(hash, v, r, s);
            }
        }

        /**
        * @dev Overload of {ECDSA-recover} that receives the `r and `vs` short-signature fields separately.
        */
        function recover(bytes32 hash, bytes32 r, bytes32 vs) internal pure returns (address) {
            (address recovered, RecoverError error, bytes32 errorArg) = tryRecover(hash, r, vs);
            _throwError(error, errorArg);
            return recovered;
        }

        /**
        * @dev Overload of {ECDSA-tryRecover} that receives the `v`,
        * `r` and `s` signature fields separately.
        */
        function tryRecover(
            bytes32 hash,
            uint8 v,
            bytes32 r,
            bytes32 s
        ) internal pure returns (address, RecoverError, bytes32) {
            // EIP-2 still allows signature malleability for ecrecover(). Remove this possibility and make the signature
            // unique. Appendix F in the Ethereum Yellow paper (https://ethereum.github.io/yellowpaper/paper.pdf), defines
            // the valid range for s in (301): 0 < s < secp256k1n ÷ 2 + 1, and for v in (302): v ∈ {27, 28}. Most
            // signatures from current libraries generate a unique signature with an s-value in the lower half order.
            //
            // If your library generates malleable signatures, such as s-values in the upper range, calculate a new s-value
            // with 0xFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFEBAAEDCE6AF48A03BBFD25E8CD0364141 - s1 and flip v from 27 to 28 or
            // vice versa. If your library also generates signatures with 0/1 for v instead 27/28, add 27 to v to accept
            // these malleable signatures as well.
            if (uint256(s) > 0x7FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF5D576E7357A4501DDFE92F46681B20A0) {
                return (address(0), RecoverError.InvalidSignatureS, s);
            }

            // If the signature is valid (and not malleable), return the signer address
            address signer = ecrecover(hash, v, r, s);
            if (signer == address(0)) {
                return (address(0), RecoverError.InvalidSignature, bytes32(0));
            }

            return (signer, RecoverError.NoError, bytes32(0));
        }

        /**
        * @dev Overload of {ECDSA-recover} that receives the `v`,
        * `r` and `s` signature fields separately.
        */
        function recover(bytes32 hash, uint8 v, bytes32 r, bytes32 s) internal pure returns (address) {
            (address recovered, RecoverError error, bytes32 errorArg) = tryRecover(hash, v, r, s);
            _throwError(error, errorArg);
            return recovered;
        }

        /**
        * @dev Optionally reverts with the corresponding custom error according to the `error` argument provided.
        */
        function _throwError(RecoverError error, bytes32 errorArg) private pure {
            if (error == RecoverError.NoError) {
                return; // no error: do nothing
            } else if (error == RecoverError.InvalidSignature) {
                revert ECDSAInvalidSignature();
            } else if (error == RecoverError.InvalidSignatureLength) {
                revert ECDSAInvalidSignatureLength(uint256(errorArg));
            } else if (error == RecoverError.InvalidSignatureS) {
                revert ECDSAInvalidSignatureS(errorArg);
            }
        }
    }


    // File openzeppelin-contracts/contracts/interfaces/IERC5267.sol

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (interfaces/IERC5267.sol)

    //pragma solidity ^0.8.20;

    interface IERC5267 {
        /**
        * @dev MAY be emitted to signal that the domain could have changed.
        */
        event EIP712DomainChanged();

        /**
        * @dev returns the fields and values that describe the domain separator used by this contract for EIP-712
        * signature.
        */
        function eip712Domain()
            external
            view
            returns (
                bytes1 fields,
                string memory name,
                string memory version,
                uint256 chainId,
                address verifyingContract,
                bytes32 salt,
                uint256[] memory extensions
            );
    }


    // File openzeppelin-contracts/contracts/utils/math/SafeCast.sol

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (utils/math/SafeCast.sol)
    // This file was procedurally generated from scripts/generate/templates/SafeCast.js.

    //pragma solidity ^0.8.20;

    /**
    * @dev Wrappers over Solidity's uintXX/intXX/bool casting operators with added overflow
    * checks.
    *
    * Downcasting from uint256/int256 in Solidity does not revert on overflow. This can
    * easily result in undesired exploitation or bugs, since developers usually
    * assume that overflows raise errors. `SafeCast` restores this intuition by
    * reverting the transaction when such an operation overflows.
    *
    * Using this library instead of the unchecked operations eliminates an entire
    * class of bugs, so it's recommended to use it always.
    */
    library SafeCast {
        /**
        * @dev Value doesn't fit in an uint of `bits` size.
        */
        error SafeCastOverflowedUintDowncast(uint8 bits, uint256 value);

        /**
        * @dev An int value doesn't fit in an uint of `bits` size.
        */
        error SafeCastOverflowedIntToUint(int256 value);

        /**
        * @dev Value doesn't fit in an int of `bits` size.
        */
        error SafeCastOverflowedIntDowncast(uint8 bits, int256 value);

        /**
        * @dev An uint value doesn't fit in an int of `bits` size.
        */
        error SafeCastOverflowedUintToInt(uint256 value);

        /**
        * @dev Returns the downcasted uint248 from uint256, reverting on
        * overflow (when the input is greater than largest uint248).
        *
        * Counterpart to Solidity's `uint248` operator.
        *
        * Requirements:
        *
        * - input must fit into 248 bits
        */
        function toUint248(uint256 value) internal pure returns (uint248) {
            if (value > type(uint248).max) {
                revert SafeCastOverflowedUintDowncast(248, value);
            }
            return uint248(value);
        }

        /**
        * @dev Returns the downcasted uint240 from uint256, reverting on
        * overflow (when the input is greater than largest uint240).
        *
        * Counterpart to Solidity's `uint240` operator.
        *
        * Requirements:
        *
        * - input must fit into 240 bits
        */
        function toUint240(uint256 value) internal pure returns (uint240) {
            if (value > type(uint240).max) {
                revert SafeCastOverflowedUintDowncast(240, value);
            }
            return uint240(value);
        }

        /**
        * @dev Returns the downcasted uint232 from uint256, reverting on
        * overflow (when the input is greater than largest uint232).
        *
        * Counterpart to Solidity's `uint232` operator.
        *
        * Requirements:
        *
        * - input must fit into 232 bits
        */
        function toUint232(uint256 value) internal pure returns (uint232) {
            if (value > type(uint232).max) {
                revert SafeCastOverflowedUintDowncast(232, value);
            }
            return uint232(value);
        }

        /**
        * @dev Returns the downcasted uint224 from uint256, reverting on
        * overflow (when the input is greater than largest uint224).
        *
        * Counterpart to Solidity's `uint224` operator.
        *
        * Requirements:
        *
        * - input must fit into 224 bits
        */
        function toUint224(uint256 value) internal pure returns (uint224) {
            if (value > type(uint224).max) {
                revert SafeCastOverflowedUintDowncast(224, value);
            }
            return uint224(value);
        }

        /**
        * @dev Returns the downcasted uint216 from uint256, reverting on
        * overflow (when the input is greater than largest uint216).
        *
        * Counterpart to Solidity's `uint216` operator.
        *
        * Requirements:
        *
        * - input must fit into 216 bits
        */
        function toUint216(uint256 value) internal pure returns (uint216) {
            if (value > type(uint216).max) {
                revert SafeCastOverflowedUintDowncast(216, value);
            }
            return uint216(value);
        }

        /**
        * @dev Returns the downcasted uint208 from uint256, reverting on
        * overflow (when the input is greater than largest uint208).
        *
        * Counterpart to Solidity's `uint208` operator.
        *
        * Requirements:
        *
        * - input must fit into 208 bits
        */
        function toUint208(uint256 value) internal pure returns (uint208) {
            if (value > type(uint208).max) {
                revert SafeCastOverflowedUintDowncast(208, value);
            }
            return uint208(value);
        }

        /**
        * @dev Returns the downcasted uint200 from uint256, reverting on
        * overflow (when the input is greater than largest uint200).
        *
        * Counterpart to Solidity's `uint200` operator.
        *
        * Requirements:
        *
        * - input must fit into 200 bits
        */
        function toUint200(uint256 value) internal pure returns (uint200) {
            if (value > type(uint200).max) {
                revert SafeCastOverflowedUintDowncast(200, value);
            }
            return uint200(value);
        }

        /**
        * @dev Returns the downcasted uint192 from uint256, reverting on
        * overflow (when the input is greater than largest uint192).
        *
        * Counterpart to Solidity's `uint192` operator.
        *
        * Requirements:
        *
        * - input must fit into 192 bits
        */
        function toUint192(uint256 value) internal pure returns (uint192) {
            if (value > type(uint192).max) {
                revert SafeCastOverflowedUintDowncast(192, value);
            }
            return uint192(value);
        }

        /**
        * @dev Returns the downcasted uint184 from uint256, reverting on
        * overflow (when the input is greater than largest uint184).
        *
        * Counterpart to Solidity's `uint184` operator.
        *
        * Requirements:
        *
        * - input must fit into 184 bits
        */
        function toUint184(uint256 value) internal pure returns (uint184) {
            if (value > type(uint184).max) {
                revert SafeCastOverflowedUintDowncast(184, value);
            }
            return uint184(value);
        }

        /**
        * @dev Returns the downcasted uint176 from uint256, reverting on
        * overflow (when the input is greater than largest uint176).
        *
        * Counterpart to Solidity's `uint176` operator.
        *
        * Requirements:
        *
        * - input must fit into 176 bits
        */
        function toUint176(uint256 value) internal pure returns (uint176) {
            if (value > type(uint176).max) {
                revert SafeCastOverflowedUintDowncast(176, value);
            }
            return uint176(value);
        }

        /**
        * @dev Returns the downcasted uint168 from uint256, reverting on
        * overflow (when the input is greater than largest uint168).
        *
        * Counterpart to Solidity's `uint168` operator.
        *
        * Requirements:
        *
        * - input must fit into 168 bits
        */
        function toUint168(uint256 value) internal pure returns (uint168) {
            if (value > type(uint168).max) {
                revert SafeCastOverflowedUintDowncast(168, value);
            }
            return uint168(value);
        }

        /**
        * @dev Returns the downcasted uint160 from uint256, reverting on
        * overflow (when the input is greater than largest uint160).
        *
        * Counterpart to Solidity's `uint160` operator.
        *
        * Requirements:
        *
        * - input must fit into 160 bits
        */
        function toUint160(uint256 value) internal pure returns (uint160) {
            if (value > type(uint160).max) {
                revert SafeCastOverflowedUintDowncast(160, value);
            }
            return uint160(value);
        }

        /**
        * @dev Returns the downcasted uint152 from uint256, reverting on
        * overflow (when the input is greater than largest uint152).
        *
        * Counterpart to Solidity's `uint152` operator.
        *
        * Requirements:
        *
        * - input must fit into 152 bits
        */
        function toUint152(uint256 value) internal pure returns (uint152) {
            if (value > type(uint152).max) {
                revert SafeCastOverflowedUintDowncast(152, value);
            }
            return uint152(value);
        }

        /**
        * @dev Returns the downcasted uint144 from uint256, reverting on
        * overflow (when the input is greater than largest uint144).
        *
        * Counterpart to Solidity's `uint144` operator.
        *
        * Requirements:
        *
        * - input must fit into 144 bits
        */
        function toUint144(uint256 value) internal pure returns (uint144) {
            if (value > type(uint144).max) {
                revert SafeCastOverflowedUintDowncast(144, value);
            }
            return uint144(value);
        }

        /**
        * @dev Returns the downcasted uint136 from uint256, reverting on
        * overflow (when the input is greater than largest uint136).
        *
        * Counterpart to Solidity's `uint136` operator.
        *
        * Requirements:
        *
        * - input must fit into 136 bits
        */
        function toUint136(uint256 value) internal pure returns (uint136) {
            if (value > type(uint136).max) {
                revert SafeCastOverflowedUintDowncast(136, value);
            }
            return uint136(value);
        }

        /**
        * @dev Returns the downcasted uint128 from uint256, reverting on
        * overflow (when the input is greater than largest uint128).
        *
        * Counterpart to Solidity's `uint128` operator.
        *
        * Requirements:
        *
        * - input must fit into 128 bits
        */
        function toUint128(uint256 value) internal pure returns (uint128) {
            if (value > type(uint128).max) {
                revert SafeCastOverflowedUintDowncast(128, value);
            }
            return uint128(value);
        }

        /**
        * @dev Returns the downcasted uint120 from uint256, reverting on
        * overflow (when the input is greater than largest uint120).
        *
        * Counterpart to Solidity's `uint120` operator.
        *
        * Requirements:
        *
        * - input must fit into 120 bits
        */
        function toUint120(uint256 value) internal pure returns (uint120) {
            if (value > type(uint120).max) {
                revert SafeCastOverflowedUintDowncast(120, value);
            }
            return uint120(value);
        }

        /**
        * @dev Returns the downcasted uint112 from uint256, reverting on
        * overflow (when the input is greater than largest uint112).
        *
        * Counterpart to Solidity's `uint112` operator.
        *
        * Requirements:
        *
        * - input must fit into 112 bits
        */
        function toUint112(uint256 value) internal pure returns (uint112) {
            if (value > type(uint112).max) {
                revert SafeCastOverflowedUintDowncast(112, value);
            }
            return uint112(value);
        }

        /**
        * @dev Returns the downcasted uint104 from uint256, reverting on
        * overflow (when the input is greater than largest uint104).
        *
        * Counterpart to Solidity's `uint104` operator.
        *
        * Requirements:
        *
        * - input must fit into 104 bits
        */
        function toUint104(uint256 value) internal pure returns (uint104) {
            if (value > type(uint104).max) {
                revert SafeCastOverflowedUintDowncast(104, value);
            }
            return uint104(value);
        }

        /**
        * @dev Returns the downcasted uint96 from uint256, reverting on
        * overflow (when the input is greater than largest uint96).
        *
        * Counterpart to Solidity's `uint96` operator.
        *
        * Requirements:
        *
        * - input must fit into 96 bits
        */
        function toUint96(uint256 value) internal pure returns (uint96) {
            if (value > type(uint96).max) {
                revert SafeCastOverflowedUintDowncast(96, value);
            }
            return uint96(value);
        }

        /**
        * @dev Returns the downcasted uint88 from uint256, reverting on
        * overflow (when the input is greater than largest uint88).
        *
        * Counterpart to Solidity's `uint88` operator.
        *
        * Requirements:
        *
        * - input must fit into 88 bits
        */
        function toUint88(uint256 value) internal pure returns (uint88) {
            if (value > type(uint88).max) {
                revert SafeCastOverflowedUintDowncast(88, value);
            }
            return uint88(value);
        }

        /**
        * @dev Returns the downcasted uint80 from uint256, reverting on
        * overflow (when the input is greater than largest uint80).
        *
        * Counterpart to Solidity's `uint80` operator.
        *
        * Requirements:
        *
        * - input must fit into 80 bits
        */
        function toUint80(uint256 value) internal pure returns (uint80) {
            if (value > type(uint80).max) {
                revert SafeCastOverflowedUintDowncast(80, value);
            }
            return uint80(value);
        }

        /**
        * @dev Returns the downcasted uint72 from uint256, reverting on
        * overflow (when the input is greater than largest uint72).
        *
        * Counterpart to Solidity's `uint72` operator.
        *
        * Requirements:
        *
        * - input must fit into 72 bits
        */
        function toUint72(uint256 value) internal pure returns (uint72) {
            if (value > type(uint72).max) {
                revert SafeCastOverflowedUintDowncast(72, value);
            }
            return uint72(value);
        }

        /**
        * @dev Returns the downcasted uint64 from uint256, reverting on
        * overflow (when the input is greater than largest uint64).
        *
        * Counterpart to Solidity's `uint64` operator.
        *
        * Requirements:
        *
        * - input must fit into 64 bits
        */
        function toUint64(uint256 value) internal pure returns (uint64) {
            if (value > type(uint64).max) {
                revert SafeCastOverflowedUintDowncast(64, value);
            }
            return uint64(value);
        }

        /**
        * @dev Returns the downcasted uint56 from uint256, reverting on
        * overflow (when the input is greater than largest uint56).
        *
        * Counterpart to Solidity's `uint56` operator.
        *
        * Requirements:
        *
        * - input must fit into 56 bits
        */
        function toUint56(uint256 value) internal pure returns (uint56) {
            if (value > type(uint56).max) {
                revert SafeCastOverflowedUintDowncast(56, value);
            }
            return uint56(value);
        }

        /**
        * @dev Returns the downcasted uint48 from uint256, reverting on
        * overflow (when the input is greater than largest uint48).
        *
        * Counterpart to Solidity's `uint48` operator.
        *
        * Requirements:
        *
        * - input must fit into 48 bits
        */
        function toUint48(uint256 value) internal pure returns (uint48) {
            if (value > type(uint48).max) {
                revert SafeCastOverflowedUintDowncast(48, value);
            }
            return uint48(value);
        }

        /**
        * @dev Returns the downcasted uint40 from uint256, reverting on
        * overflow (when the input is greater than largest uint40).
        *
        * Counterpart to Solidity's `uint40` operator.
        *
        * Requirements:
        *
        * - input must fit into 40 bits
        */
        function toUint40(uint256 value) internal pure returns (uint40) {
            if (value > type(uint40).max) {
                revert SafeCastOverflowedUintDowncast(40, value);
            }
            return uint40(value);
        }

        /**
        * @dev Returns the downcasted uint32 from uint256, reverting on
        * overflow (when the input is greater than largest uint32).
        *
        * Counterpart to Solidity's `uint32` operator.
        *
        * Requirements:
        *
        * - input must fit into 32 bits
        */
        function toUint32(uint256 value) internal pure returns (uint32) {
            if (value > type(uint32).max) {
                revert SafeCastOverflowedUintDowncast(32, value);
            }
            return uint32(value);
        }

        /**
        * @dev Returns the downcasted uint24 from uint256, reverting on
        * overflow (when the input is greater than largest uint24).
        *
        * Counterpart to Solidity's `uint24` operator.
        *
        * Requirements:
        *
        * - input must fit into 24 bits
        */
        function toUint24(uint256 value) internal pure returns (uint24) {
            if (value > type(uint24).max) {
                revert SafeCastOverflowedUintDowncast(24, value);
            }
            return uint24(value);
        }

        /**
        * @dev Returns the downcasted uint16 from uint256, reverting on
        * overflow (when the input is greater than largest uint16).
        *
        * Counterpart to Solidity's `uint16` operator.
        *
        * Requirements:
        *
        * - input must fit into 16 bits
        */
        function toUint16(uint256 value) internal pure returns (uint16) {
            if (value > type(uint16).max) {
                revert SafeCastOverflowedUintDowncast(16, value);
            }
            return uint16(value);
        }

        /**
        * @dev Returns the downcasted uint8 from uint256, reverting on
        * overflow (when the input is greater than largest uint8).
        *
        * Counterpart to Solidity's `uint8` operator.
        *
        * Requirements:
        *
        * - input must fit into 8 bits
        */
        function toUint8(uint256 value) internal pure returns (uint8) {
            if (value > type(uint8).max) {
                revert SafeCastOverflowedUintDowncast(8, value);
            }
            return uint8(value);
        }

        /**
        * @dev Converts a signed int256 into an unsigned uint256.
        *
        * Requirements:
        *
        * - input must be greater than or equal to 0.
        */
        function toUint256(int256 value) internal pure returns (uint256) {
            if (value < 0) {
                revert SafeCastOverflowedIntToUint(value);
            }
            return uint256(value);
        }

        /**
        * @dev Returns the downcasted int248 from int256, reverting on
        * overflow (when the input is less than smallest int248 or
        * greater than largest int248).
        *
        * Counterpart to Solidity's `int248` operator.
        *
        * Requirements:
        *
        * - input must fit into 248 bits
        */
        function toInt248(int256 value) internal pure returns (int248 downcasted) {
            downcasted = int248(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(248, value);
            }
        }

        /**
        * @dev Returns the downcasted int240 from int256, reverting on
        * overflow (when the input is less than smallest int240 or
        * greater than largest int240).
        *
        * Counterpart to Solidity's `int240` operator.
        *
        * Requirements:
        *
        * - input must fit into 240 bits
        */
        function toInt240(int256 value) internal pure returns (int240 downcasted) {
            downcasted = int240(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(240, value);
            }
        }

        /**
        * @dev Returns the downcasted int232 from int256, reverting on
        * overflow (when the input is less than smallest int232 or
        * greater than largest int232).
        *
        * Counterpart to Solidity's `int232` operator.
        *
        * Requirements:
        *
        * - input must fit into 232 bits
        */
        function toInt232(int256 value) internal pure returns (int232 downcasted) {
            downcasted = int232(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(232, value);
            }
        }

        /**
        * @dev Returns the downcasted int224 from int256, reverting on
        * overflow (when the input is less than smallest int224 or
        * greater than largest int224).
        *
        * Counterpart to Solidity's `int224` operator.
        *
        * Requirements:
        *
        * - input must fit into 224 bits
        */
        function toInt224(int256 value) internal pure returns (int224 downcasted) {
            downcasted = int224(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(224, value);
            }
        }

        /**
        * @dev Returns the downcasted int216 from int256, reverting on
        * overflow (when the input is less than smallest int216 or
        * greater than largest int216).
        *
        * Counterpart to Solidity's `int216` operator.
        *
        * Requirements:
        *
        * - input must fit into 216 bits
        */
        function toInt216(int256 value) internal pure returns (int216 downcasted) {
            downcasted = int216(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(216, value);
            }
        }

        /**
        * @dev Returns the downcasted int208 from int256, reverting on
        * overflow (when the input is less than smallest int208 or
        * greater than largest int208).
        *
        * Counterpart to Solidity's `int208` operator.
        *
        * Requirements:
        *
        * - input must fit into 208 bits
        */
        function toInt208(int256 value) internal pure returns (int208 downcasted) {
            downcasted = int208(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(208, value);
            }
        }

        /**
        * @dev Returns the downcasted int200 from int256, reverting on
        * overflow (when the input is less than smallest int200 or
        * greater than largest int200).
        *
        * Counterpart to Solidity's `int200` operator.
        *
        * Requirements:
        *
        * - input must fit into 200 bits
        */
        function toInt200(int256 value) internal pure returns (int200 downcasted) {
            downcasted = int200(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(200, value);
            }
        }

        /**
        * @dev Returns the downcasted int192 from int256, reverting on
        * overflow (when the input is less than smallest int192 or
        * greater than largest int192).
        *
        * Counterpart to Solidity's `int192` operator.
        *
        * Requirements:
        *
        * - input must fit into 192 bits
        */
        function toInt192(int256 value) internal pure returns (int192 downcasted) {
            downcasted = int192(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(192, value);
            }
        }

        /**
        * @dev Returns the downcasted int184 from int256, reverting on
        * overflow (when the input is less than smallest int184 or
        * greater than largest int184).
        *
        * Counterpart to Solidity's `int184` operator.
        *
        * Requirements:
        *
        * - input must fit into 184 bits
        */
        function toInt184(int256 value) internal pure returns (int184 downcasted) {
            downcasted = int184(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(184, value);
            }
        }

        /**
        * @dev Returns the downcasted int176 from int256, reverting on
        * overflow (when the input is less than smallest int176 or
        * greater than largest int176).
        *
        * Counterpart to Solidity's `int176` operator.
        *
        * Requirements:
        *
        * - input must fit into 176 bits
        */
        function toInt176(int256 value) internal pure returns (int176 downcasted) {
            downcasted = int176(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(176, value);
            }
        }

        /**
        * @dev Returns the downcasted int168 from int256, reverting on
        * overflow (when the input is less than smallest int168 or
        * greater than largest int168).
        *
        * Counterpart to Solidity's `int168` operator.
        *
        * Requirements:
        *
        * - input must fit into 168 bits
        */
        function toInt168(int256 value) internal pure returns (int168 downcasted) {
            downcasted = int168(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(168, value);
            }
        }

        /**
        * @dev Returns the downcasted int160 from int256, reverting on
        * overflow (when the input is less than smallest int160 or
        * greater than largest int160).
        *
        * Counterpart to Solidity's `int160` operator.
        *
        * Requirements:
        *
        * - input must fit into 160 bits
        */
        function toInt160(int256 value) internal pure returns (int160 downcasted) {
            downcasted = int160(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(160, value);
            }
        }

        /**
        * @dev Returns the downcasted int152 from int256, reverting on
        * overflow (when the input is less than smallest int152 or
        * greater than largest int152).
        *
        * Counterpart to Solidity's `int152` operator.
        *
        * Requirements:
        *
        * - input must fit into 152 bits
        */
        function toInt152(int256 value) internal pure returns (int152 downcasted) {
            downcasted = int152(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(152, value);
            }
        }

        /**
        * @dev Returns the downcasted int144 from int256, reverting on
        * overflow (when the input is less than smallest int144 or
        * greater than largest int144).
        *
        * Counterpart to Solidity's `int144` operator.
        *
        * Requirements:
        *
        * - input must fit into 144 bits
        */
        function toInt144(int256 value) internal pure returns (int144 downcasted) {
            downcasted = int144(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(144, value);
            }
        }

        /**
        * @dev Returns the downcasted int136 from int256, reverting on
        * overflow (when the input is less than smallest int136 or
        * greater than largest int136).
        *
        * Counterpart to Solidity's `int136` operator.
        *
        * Requirements:
        *
        * - input must fit into 136 bits
        */
        function toInt136(int256 value) internal pure returns (int136 downcasted) {
            downcasted = int136(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(136, value);
            }
        }

        /**
        * @dev Returns the downcasted int128 from int256, reverting on
        * overflow (when the input is less than smallest int128 or
        * greater than largest int128).
        *
        * Counterpart to Solidity's `int128` operator.
        *
        * Requirements:
        *
        * - input must fit into 128 bits
        */
        function toInt128(int256 value) internal pure returns (int128 downcasted) {
            downcasted = int128(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(128, value);
            }
        }

        /**
        * @dev Returns the downcasted int120 from int256, reverting on
        * overflow (when the input is less than smallest int120 or
        * greater than largest int120).
        *
        * Counterpart to Solidity's `int120` operator.
        *
        * Requirements:
        *
        * - input must fit into 120 bits
        */
        function toInt120(int256 value) internal pure returns (int120 downcasted) {
            downcasted = int120(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(120, value);
            }
        }

        /**
        * @dev Returns the downcasted int112 from int256, reverting on
        * overflow (when the input is less than smallest int112 or
        * greater than largest int112).
        *
        * Counterpart to Solidity's `int112` operator.
        *
        * Requirements:
        *
        * - input must fit into 112 bits
        */
        function toInt112(int256 value) internal pure returns (int112 downcasted) {
            downcasted = int112(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(112, value);
            }
        }

        /**
        * @dev Returns the downcasted int104 from int256, reverting on
        * overflow (when the input is less than smallest int104 or
        * greater than largest int104).
        *
        * Counterpart to Solidity's `int104` operator.
        *
        * Requirements:
        *
        * - input must fit into 104 bits
        */
        function toInt104(int256 value) internal pure returns (int104 downcasted) {
            downcasted = int104(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(104, value);
            }
        }

        /**
        * @dev Returns the downcasted int96 from int256, reverting on
        * overflow (when the input is less than smallest int96 or
        * greater than largest int96).
        *
        * Counterpart to Solidity's `int96` operator.
        *
        * Requirements:
        *
        * - input must fit into 96 bits
        */
        function toInt96(int256 value) internal pure returns (int96 downcasted) {
            downcasted = int96(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(96, value);
            }
        }

        /**
        * @dev Returns the downcasted int88 from int256, reverting on
        * overflow (when the input is less than smallest int88 or
        * greater than largest int88).
        *
        * Counterpart to Solidity's `int88` operator.
        *
        * Requirements:
        *
        * - input must fit into 88 bits
        */
        function toInt88(int256 value) internal pure returns (int88 downcasted) {
            downcasted = int88(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(88, value);
            }
        }

        /**
        * @dev Returns the downcasted int80 from int256, reverting on
        * overflow (when the input is less than smallest int80 or
        * greater than largest int80).
        *
        * Counterpart to Solidity's `int80` operator.
        *
        * Requirements:
        *
        * - input must fit into 80 bits
        */
        function toInt80(int256 value) internal pure returns (int80 downcasted) {
            downcasted = int80(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(80, value);
            }
        }

        /**
        * @dev Returns the downcasted int72 from int256, reverting on
        * overflow (when the input is less than smallest int72 or
        * greater than largest int72).
        *
        * Counterpart to Solidity's `int72` operator.
        *
        * Requirements:
        *
        * - input must fit into 72 bits
        */
        function toInt72(int256 value) internal pure returns (int72 downcasted) {
            downcasted = int72(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(72, value);
            }
        }

        /**
        * @dev Returns the downcasted int64 from int256, reverting on
        * overflow (when the input is less than smallest int64 or
        * greater than largest int64).
        *
        * Counterpart to Solidity's `int64` operator.
        *
        * Requirements:
        *
        * - input must fit into 64 bits
        */
        function toInt64(int256 value) internal pure returns (int64 downcasted) {
            downcasted = int64(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(64, value);
            }
        }

        /**
        * @dev Returns the downcasted int56 from int256, reverting on
        * overflow (when the input is less than smallest int56 or
        * greater than largest int56).
        *
        * Counterpart to Solidity's `int56` operator.
        *
        * Requirements:
        *
        * - input must fit into 56 bits
        */
        function toInt56(int256 value) internal pure returns (int56 downcasted) {
            downcasted = int56(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(56, value);
            }
        }

        /**
        * @dev Returns the downcasted int48 from int256, reverting on
        * overflow (when the input is less than smallest int48 or
        * greater than largest int48).
        *
        * Counterpart to Solidity's `int48` operator.
        *
        * Requirements:
        *
        * - input must fit into 48 bits
        */
        function toInt48(int256 value) internal pure returns (int48 downcasted) {
            downcasted = int48(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(48, value);
            }
        }

        /**
        * @dev Returns the downcasted int40 from int256, reverting on
        * overflow (when the input is less than smallest int40 or
        * greater than largest int40).
        *
        * Counterpart to Solidity's `int40` operator.
        *
        * Requirements:
        *
        * - input must fit into 40 bits
        */
        function toInt40(int256 value) internal pure returns (int40 downcasted) {
            downcasted = int40(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(40, value);
            }
        }

        /**
        * @dev Returns the downcasted int32 from int256, reverting on
        * overflow (when the input is less than smallest int32 or
        * greater than largest int32).
        *
        * Counterpart to Solidity's `int32` operator.
        *
        * Requirements:
        *
        * - input must fit into 32 bits
        */
        function toInt32(int256 value) internal pure returns (int32 downcasted) {
            downcasted = int32(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(32, value);
            }
        }

        /**
        * @dev Returns the downcasted int24 from int256, reverting on
        * overflow (when the input is less than smallest int24 or
        * greater than largest int24).
        *
        * Counterpart to Solidity's `int24` operator.
        *
        * Requirements:
        *
        * - input must fit into 24 bits
        */
        function toInt24(int256 value) internal pure returns (int24 downcasted) {
            downcasted = int24(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(24, value);
            }
        }

        /**
        * @dev Returns the downcasted int16 from int256, reverting on
        * overflow (when the input is less than smallest int16 or
        * greater than largest int16).
        *
        * Counterpart to Solidity's `int16` operator.
        *
        * Requirements:
        *
        * - input must fit into 16 bits
        */
        function toInt16(int256 value) internal pure returns (int16 downcasted) {
            downcasted = int16(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(16, value);
            }
        }

        /**
        * @dev Returns the downcasted int8 from int256, reverting on
        * overflow (when the input is less than smallest int8 or
        * greater than largest int8).
        *
        * Counterpart to Solidity's `int8` operator.
        *
        * Requirements:
        *
        * - input must fit into 8 bits
        */
        function toInt8(int256 value) internal pure returns (int8 downcasted) {
            downcasted = int8(value);
            if (downcasted != value) {
                revert SafeCastOverflowedIntDowncast(8, value);
            }
        }

        /**
        * @dev Converts an unsigned uint256 into a signed int256.
        *
        * Requirements:
        *
        * - input must be less than or equal to maxInt256.
        */
        function toInt256(uint256 value) internal pure returns (int256) {
            // Note: Unsafe cast below is okay because `type(int256).max` is guaranteed to be positive
            if (value > uint256(type(int256).max)) {
                revert SafeCastOverflowedUintToInt(value);
            }
            return int256(value);
        }

        /**
        * @dev Cast a boolean (false or true) to a uint256 (0 or 1) with no jump.
        */
        function toUint(bool b) internal pure returns (uint256 u) {
            /// @solidity memory-safe-assembly
            assembly {
                u := iszero(iszero(b))
            }
        }
    }


    // File openzeppelin-contracts/contracts/utils/Panic.sol

    // Original license: SPDX_License_Identifier: MIT

    //pragma solidity ^0.8.20;

    /**
    * @dev Helper library for emitting standardized panic codes.
    *
    * ```solidity
    * contract Example {
    *      using Panic for uint256;
    *
    *      // Use any of the declared internal constants
    *      function foo() { Panic.GENERIC.panic(); }
    *
    *      // Alternatively
    *      function foo() { Panic.panic(Panic.GENERIC); }
    * }
    * ```
    *
    * Follows the list from https://github.com/ethereum/solidity/blob/v0.8.24/libsolutil/ErrorCodes.h[libsolutil].
    */
    // slither-disable-next-line unused-state
    library Panic {
        /// @dev generic / unspecified error
        uint256 internal constant GENERIC = 0x00;
        /// @dev used by the assert() builtin
        uint256 internal constant ASSERT = 0x01;
        /// @dev arithmetic underflow or overflow
        uint256 internal constant UNDER_OVERFLOW = 0x11;
        /// @dev division or modulo by zero
        uint256 internal constant DIVISION_BY_ZERO = 0x12;
        /// @dev enum conversion error
        uint256 internal constant ENUM_CONVERSION_ERROR = 0x21;
        /// @dev invalid encoding in storage
        uint256 internal constant STORAGE_ENCODING_ERROR = 0x22;
        /// @dev empty array pop
        uint256 internal constant EMPTY_ARRAY_POP = 0x31;
        /// @dev array out of bounds access
        uint256 internal constant ARRAY_OUT_OF_BOUNDS = 0x32;
        /// @dev resource error (too large allocation or too large array)
        uint256 internal constant RESOURCE_ERROR = 0x41;
        /// @dev calling invalid internal function
        uint256 internal constant INVALID_INTERNAL_FUNCTION = 0x51;

        /// @dev Reverts with a panic code. Recommended to use with
        /// the internal constants with predefined codes.
        function panic(uint256 code) internal pure {
            /// @solidity memory-safe-assembly
            assembly {
                mstore(0x00, 0x4e487b71)
                mstore(0x20, code)
                revert(0x1c, 0x24)
            }
        }
    }


    // File openzeppelin-contracts/contracts/utils/math/Math.sol

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (utils/math/Math.sol)

    //pragma solidity ^0.8.20;
    /**
    * @dev Standard math utilities missing in the Solidity language.
    */
    library Math {
        enum Rounding {
            Floor, // Toward negative infinity
            Ceil, // Toward positive infinity
            Trunc, // Toward zero
            Expand // Away from zero
        }

        /**
        * @dev Returns the addition of two unsigned integers, with an success flag (no overflow).
        */
        function tryAdd(uint256 a, uint256 b) internal pure returns (bool success, uint256 result) {
            unchecked {
                uint256 c = a + b;
                if (c < a) return (false, 0);
                return (true, c);
            }
        }

        /**
        * @dev Returns the subtraction of two unsigned integers, with an success flag (no overflow).
        */
        function trySub(uint256 a, uint256 b) internal pure returns (bool success, uint256 result) {
            unchecked {
                if (b > a) return (false, 0);
                return (true, a - b);
            }
        }

        /**
        * @dev Returns the multiplication of two unsigned integers, with an success flag (no overflow).
        */
        function tryMul(uint256 a, uint256 b) internal pure returns (bool success, uint256 result) {
            unchecked {
                // Gas optimization: this is cheaper than requiring 'a' not being zero, but the
                // benefit is lost if 'b' is also tested.
                // See: https://github.com/OpenZeppelin/openzeppelin-contracts/pull/522
                if (a == 0) return (true, 0);
                uint256 c = a * b;
                if (c / a != b) return (false, 0);
                return (true, c);
            }
        }

        /**
        * @dev Returns the division of two unsigned integers, with a success flag (no division by zero).
        */
        function tryDiv(uint256 a, uint256 b) internal pure returns (bool success, uint256 result) {
            unchecked {
                if (b == 0) return (false, 0);
                return (true, a / b);
            }
        }

        /**
        * @dev Returns the remainder of dividing two unsigned integers, with a success flag (no division by zero).
        */
        function tryMod(uint256 a, uint256 b) internal pure returns (bool success, uint256 result) {
            unchecked {
                if (b == 0) return (false, 0);
                return (true, a % b);
            }
        }

        /**
        * @dev Returns the largest of two numbers.
        */
        function max(uint256 a, uint256 b) internal pure returns (uint256) {
            return a > b ? a : b;
        }

        /**
        * @dev Returns the smallest of two numbers.
        */
        function min(uint256 a, uint256 b) internal pure returns (uint256) {
            return a < b ? a : b;
        }

        /**
        * @dev Returns the average of two numbers. The result is rounded towards
        * zero.
        */
        function average(uint256 a, uint256 b) internal pure returns (uint256) {
            // (a + b) / 2 can overflow.
            return (a & b) + (a ^ b) / 2;
        }

        /**
        * @dev Returns the ceiling of the division of two numbers.
        *
        * This differs from standard division with `/` in that it rounds towards infinity instead
        * of rounding towards zero.
        */
        function ceilDiv(uint256 a, uint256 b) internal pure returns (uint256) {
            if (b == 0) {
                // Guarantee the same behavior as in a regular Solidity division.
                Panic.panic(Panic.DIVISION_BY_ZERO);
            }

            // The following calculation ensures accurate ceiling division without overflow.
            // Since a is non-zero, (a - 1) / b will not overflow.
            // The largest possible result occurs when (a - 1) / b is type(uint256).max,
            // but the largest value we can obtain is type(uint256).max - 1, which happens
            // when a = type(uint256).max and b = 1.
            unchecked {
                return a == 0 ? 0 : (a - 1) / b + 1;
            }
        }

        /**
        * @dev Calculates floor(x * y / denominator) with full precision. Throws if result overflows a uint256 or
        * denominator == 0.
        *
        * Original credit to Remco Bloemen under MIT license (https://xn--2-umb.com/21/muldiv) with further edits by
        * Uniswap Labs also under MIT license.
        */
        function mulDiv(uint256 x, uint256 y, uint256 denominator) internal pure returns (uint256 result) {
            unchecked {
                // 512-bit multiply [prod1 prod0] = x * y. Compute the product mod 2²⁵⁶ and mod 2²⁵⁶ - 1, then use
                // use the Chinese Remainder Theorem to reconstruct the 512 bit result. The result is stored in two 256
                // variables such that product = prod1 * 2²⁵⁶ + prod0.
                uint256 prod0 = x * y; // Least significant 256 bits of the product
                uint256 prod1; // Most significant 256 bits of the product
                assembly {
                    let mm := mulmod(x, y, not(0))
                    prod1 := sub(sub(mm, prod0), lt(mm, prod0))
                }

                // Handle non-overflow cases, 256 by 256 division.
                if (prod1 == 0) {
                    // Solidity will revert if denominator == 0, unlike the div opcode on its own.
                    // The surrounding unchecked block does not change this fact.
                    // See https://docs.soliditylang.org/en/latest/control-structures.html#checked-or-unchecked-arithmetic.
                    return prod0 / denominator;
                }

                // Make sure the result is less than 2²⁵⁶. Also prevents denominator == 0.
                if (denominator <= prod1) {
                    Panic.panic(denominator == 0 ? Panic.DIVISION_BY_ZERO : Panic.UNDER_OVERFLOW);
                }

                ///////////////////////////////////////////////
                // 512 by 256 division.
                ///////////////////////////////////////////////

                // Make division exact by subtracting the remainder from [prod1 prod0].
                uint256 remainder;
                assembly {
                    // Compute remainder using mulmod.
                    remainder := mulmod(x, y, denominator)

                    // Subtract 256 bit number from 512 bit number.
                    prod1 := sub(prod1, gt(remainder, prod0))
                    prod0 := sub(prod0, remainder)
                }

                // Factor powers of two out of denominator and compute largest power of two divisor of denominator.
                // Always >= 1. See https://cs.stackexchange.com/q/138556/92363.

                uint256 twos = denominator & (0 - denominator);
                assembly {
                    // Divide denominator by twos.
                    denominator := div(denominator, twos)

                    // Divide [prod1 prod0] by twos.
                    prod0 := div(prod0, twos)

                    // Flip twos such that it is 2²⁵⁶ / twos. If twos is zero, then it becomes one.
                    twos := add(div(sub(0, twos), twos), 1)
                }

                // Shift in bits from prod1 into prod0.
                prod0 |= prod1 * twos;

                // Invert denominator mod 2²⁵⁶. Now that denominator is an odd number, it has an inverse modulo 2²⁵⁶ such
                // that denominator * inv ≡ 1 mod 2²⁵⁶. Compute the inverse by starting with a seed that is correct for
                // four bits. That is, denominator * inv ≡ 1 mod 2⁴.
                uint256 inverse = (3 * denominator) ^ 2;

                // Use the Newton-Raphson iteration to improve the precision. Thanks to Hensel's lifting lemma, this also
                // works in modular arithmetic, doubling the correct bits in each step.
                inverse *= 2 - denominator * inverse; // inverse mod 2⁸
                inverse *= 2 - denominator * inverse; // inverse mod 2¹⁶
                inverse *= 2 - denominator * inverse; // inverse mod 2³²
                inverse *= 2 - denominator * inverse; // inverse mod 2⁶⁴
                inverse *= 2 - denominator * inverse; // inverse mod 2¹²⁸
                inverse *= 2 - denominator * inverse; // inverse mod 2²⁵⁶

                // Because the division is now exact we can divide by multiplying with the modular inverse of denominator.
                // This will give us the correct result modulo 2²⁵⁶. Since the preconditions guarantee that the outcome is
                // less than 2²⁵⁶, this is the final result. We don't need to compute the high bits of the result and prod1
                // is no longer required.
                result = prod0 * inverse;
                return result;
            }
        }

        /**
        * @dev Calculates x * y / denominator with full precision, following the selected rounding direction.
        */
        function mulDiv(uint256 x, uint256 y, uint256 denominator, Rounding rounding) internal pure returns (uint256) {
            return mulDiv(x, y, denominator) + SafeCast.toUint(unsignedRoundsUp(rounding) && mulmod(x, y, denominator) > 0);
        }

        /**
        * @dev Calculate the modular multiplicative inverse of a number in Z/nZ.
        *
        * If n is a prime, then Z/nZ is a field. In that case all elements are inversible, expect 0.
        * If n is not a prime, then Z/nZ is not a field, and some elements might not be inversible.
        *
        * If the input value is not inversible, 0 is returned.
        *
        * NOTE: If you know for sure that n is (big) a prime, it may be cheaper to use Ferma's little theorem and get the
        * inverse using `Math.modExp(a, n - 2, n)`.
        */
        function invMod(uint256 a, uint256 n) internal pure returns (uint256) {
            unchecked {
                if (n == 0) return 0;

                // The inverse modulo is calculated using the Extended Euclidean Algorithm (iterative version)
                // Used to compute integers x and y such that: ax + ny = gcd(a, n).
                // When the gcd is 1, then the inverse of a modulo n exists and it's x.
                // ax + ny = 1
                // ax = 1 + (-y)n
                // ax ≡ 1 (mod n) # x is the inverse of a modulo n

                // If the remainder is 0 the gcd is n right away.
                uint256 remainder = a % n;
                uint256 gcd = n;

                // Therefore the initial coefficients are:
                // ax + ny = gcd(a, n) = n
                // 0a + 1n = n
                int256 x = 0;
                int256 y = 1;

                while (remainder != 0) {
                    uint256 quotient = gcd / remainder;

                    (gcd, remainder) = (
                        // The old remainder is the next gcd to try.
                        remainder,
                        // Compute the next remainder.
                        // Can't overflow given that (a % gcd) * (gcd // (a % gcd)) <= gcd
                        // where gcd is at most n (capped to type(uint256).max)
                        gcd - remainder * quotient
                    );

                    (x, y) = (
                        // Increment the coefficient of a.
                        y,
                        // Decrement the coefficient of n.
                        // Can overflow, but the result is casted to uint256 so that the
                        // next value of y is "wrapped around" to a value between 0 and n - 1.
                        x - y * int256(quotient)
                    );
                }

                if (gcd != 1) return 0; // No inverse exists.
                return x < 0 ? (n - uint256(-x)) : uint256(x); // Wrap the result if it's negative.
            }
        }

        /**
        * @dev Returns the modular exponentiation of the specified base, exponent and modulus (b ** e % m)
        *
        * Requirements:
        * - modulus can't be zero
        * - underlying staticcall to precompile must succeed
        *
        * IMPORTANT: The result is only valid if the underlying call succeeds. When using this function, make
        * sure the chain you're using it on supports the precompiled contract for modular exponentiation
        * at address 0x05 as specified in https://eips.ethereum.org/EIPS/eip-198[EIP-198]. Otherwise,
        * the underlying function will succeed given the lack of a revert, but the result may be incorrectly
        * interpreted as 0.
        */
        function modExp(uint256 b, uint256 e, uint256 m) internal view returns (uint256) {
            (bool success, uint256 result) = tryModExp(b, e, m);
            if (!success) {
                Panic.panic(Panic.DIVISION_BY_ZERO);
            }
            return result;
        }

        /**
        * @dev Returns the modular exponentiation of the specified base, exponent and modulus (b ** e % m).
        * It includes a success flag indicating if the operation succeeded. Operation will be marked has failed if trying
        * to operate modulo 0 or if the underlying precompile reverted.
        *
        * IMPORTANT: The result is only valid if the success flag is true. When using this function, make sure the chain
        * you're using it on supports the precompiled contract for modular exponentiation at address 0x05 as specified in
        * https://eips.ethereum.org/EIPS/eip-198[EIP-198]. Otherwise, the underlying function will succeed given the lack
        * of a revert, but the result may be incorrectly interpreted as 0.
        */
        function tryModExp(uint256 b, uint256 e, uint256 m) internal view returns (bool success, uint256 result) {
            if (m == 0) return (false, 0);
            /// @solidity memory-safe-assembly
            assembly {
                let ptr := mload(0x40)
                // | Offset    | Content    | Content (Hex)                                                      |
                // |-----------|------------|--------------------------------------------------------------------|
                // | 0x00:0x1f | size of b  | 0x0000000000000000000000000000000000000000000000000000000000000020 |
                // | 0x20:0x3f | size of e  | 0x0000000000000000000000000000000000000000000000000000000000000020 |
                // | 0x40:0x5f | size of m  | 0x0000000000000000000000000000000000000000000000000000000000000020 |
                // | 0x60:0x7f | value of b | 0x<.............................................................b> |
                // | 0x80:0x9f | value of e | 0x<.............................................................e> |
                // | 0xa0:0xbf | value of m | 0x<.............................................................m> |
                mstore(ptr, 0x20)
                mstore(add(ptr, 0x20), 0x20)
                mstore(add(ptr, 0x40), 0x20)
                mstore(add(ptr, 0x60), b)
                mstore(add(ptr, 0x80), e)
                mstore(add(ptr, 0xa0), m)

                // Given the result < m, it's guaranteed to fit in 32 bytes,
                // so we can use the memory scratch space located at offset 0.
                success := staticcall(gas(), 0x05, ptr, 0xc0, 0x00, 0x20)
                result := mload(0x00)
            }
        }

        /**
        * @dev Variant of {modExp} that supports inputs of arbitrary length.
        */
        function modExp(bytes memory b, bytes memory e, bytes memory m) internal view returns (bytes memory) {
            (bool success, bytes memory result) = tryModExp(b, e, m);
            if (!success) {
                Panic.panic(Panic.DIVISION_BY_ZERO);
            }
            return result;
        }

        /**
        * @dev Variant of {tryModExp} that supports inputs of arbitrary length.
        */
        function tryModExp(
            bytes memory b,
            bytes memory e,
            bytes memory m
        ) internal view returns (bool success, bytes memory result) {
            if (_zeroBytes(m)) return (false, new bytes(0));

            uint256 mLen = m.length;

            // Encode call args in result and move the free memory pointer
            result = abi.encodePacked(b.length, e.length, mLen, b, e, m);

            /// @solidity memory-safe-assembly
            assembly {
                let dataPtr := add(result, 0x20)
                // Write result on top of args to avoid allocating extra memory.
                success := staticcall(gas(), 0x05, dataPtr, mload(result), dataPtr, mLen)
                // Overwrite the length.
                // result.length > returndatasize() is guaranteed because returndatasize() == m.length
                mstore(result, mLen)
                // Set the memory pointer after the returned data.
                mstore(0x40, add(dataPtr, mLen))
            }
        }

        /**
        * @dev Returns whether the provided byte array is zero.
        */
        function _zeroBytes(bytes memory byteArray) private pure returns (bool) {
            for (uint256 i = 0; i < byteArray.length; ++i) {
                if (byteArray[i] != 0) {
                    return false;
                }
            }
            return true;
        }

        /**
        * @dev Returns the square root of a number. If the number is not a perfect square, the value is rounded
        * towards zero.
        *
        * This method is based on Newton's method for computing square roots; the algorithm is restricted to only
        * using integer operations.
        */
        function sqrt(uint256 a) internal pure returns (uint256) {
            unchecked {
                // Take care of easy edge cases when a == 0 or a == 1
                if (a <= 1) {
                    return a;
                }

                // In this function, we use Newton's method to get a root of `f(x) := x² - a`. It involves building a
                // sequence x_n that converges toward sqrt(a). For each iteration x_n, we also define the error between
                // the current value as `ε_n = | x_n - sqrt(a) |`.
                //
                // For our first estimation, we consider `e` the smallest power of 2 which is bigger than the square root
                // of the target. (i.e. `2**(e-1) ≤ sqrt(a) < 2**e`). We know that `e ≤ 128` because `(2¹²⁸)² = 2²⁵⁶` is
                // bigger than any uint256.
                //
                // By noticing that
                // `2**(e-1) ≤ sqrt(a) < 2**e → (2**(e-1))² ≤ a < (2**e)² → 2**(2*e-2) ≤ a < 2**(2*e)`
                // we can deduce that `e - 1` is `log2(a) / 2`. We can thus compute `x_n = 2**(e-1)` using a method similar
                // to the msb function.
                uint256 aa = a;
                uint256 xn = 1;

                if (aa >= (1 << 128)) {
                    aa >>= 128;
                    xn <<= 64;
                }
                if (aa >= (1 << 64)) {
                    aa >>= 64;
                    xn <<= 32;
                }
                if (aa >= (1 << 32)) {
                    aa >>= 32;
                    xn <<= 16;
                }
                if (aa >= (1 << 16)) {
                    aa >>= 16;
                    xn <<= 8;
                }
                if (aa >= (1 << 8)) {
                    aa >>= 8;
                    xn <<= 4;
                }
                if (aa >= (1 << 4)) {
                    aa >>= 4;
                    xn <<= 2;
                }
                if (aa >= (1 << 2)) {
                    xn <<= 1;
                }

                // We now have x_n such that `x_n = 2**(e-1) ≤ sqrt(a) < 2**e = 2 * x_n`. This implies ε_n ≤ 2**(e-1).
                //
                // We can refine our estimation by noticing that the middle of that interval minimizes the error.
                // If we move x_n to equal 2**(e-1) + 2**(e-2), then we reduce the error to ε_n ≤ 2**(e-2).
                // This is going to be our x_0 (and ε_0)
                xn = (3 * xn) >> 1; // ε_0 := | x_0 - sqrt(a) | ≤ 2**(e-2)

                // From here, Newton's method give us:
                // x_{n+1} = (x_n + a / x_n) / 2
                //
                // One should note that:
                // x_{n+1}² - a = ((x_n + a / x_n) / 2)² - a
                //              = ((x_n² + a) / (2 * x_n))² - a
                //              = (x_n⁴ + 2 * a * x_n² + a²) / (4 * x_n²) - a
                //              = (x_n⁴ + 2 * a * x_n² + a² - 4 * a * x_n²) / (4 * x_n²)
                //              = (x_n⁴ - 2 * a * x_n² + a²) / (4 * x_n²)
                //              = (x_n² - a)² / (2 * x_n)²
                //              = ((x_n² - a) / (2 * x_n))²
                //              ≥ 0
                // Which proves that for all n ≥ 1, sqrt(a) ≤ x_n
                //
                // This gives us the proof of quadratic convergence of the sequence:
                // ε_{n+1} = | x_{n+1} - sqrt(a) |
                //         = | (x_n + a / x_n) / 2 - sqrt(a) |
                //         = | (x_n² + a - 2*x_n*sqrt(a)) / (2 * x_n) |
                //         = | (x_n - sqrt(a))² / (2 * x_n) |
                //         = | ε_n² / (2 * x_n) |
                //         = ε_n² / | (2 * x_n) |
                //
                // For the first iteration, we have a special case where x_0 is known:
                // ε_1 = ε_0² / | (2 * x_0) |
                //     ≤ (2**(e-2))² / (2 * (2**(e-1) + 2**(e-2)))
                //     ≤ 2**(2*e-4) / (3 * 2**(e-1))
                //     ≤ 2**(e-3) / 3
                //     ≤ 2**(e-3-log2(3))
                //     ≤ 2**(e-4.5)
                //
                // For the following iterations, we use the fact that, 2**(e-1) ≤ sqrt(a) ≤ x_n:
                // ε_{n+1} = ε_n² / | (2 * x_n) |
                //         ≤ (2**(e-k))² / (2 * 2**(e-1))
                //         ≤ 2**(2*e-2*k) / 2**e
                //         ≤ 2**(e-2*k)
                xn = (xn + a / xn) >> 1; // ε_1 := | x_1 - sqrt(a) | ≤ 2**(e-4.5)  -- special case, see above
                xn = (xn + a / xn) >> 1; // ε_2 := | x_2 - sqrt(a) | ≤ 2**(e-9)    -- general case with k = 4.5
                xn = (xn + a / xn) >> 1; // ε_3 := | x_3 - sqrt(a) | ≤ 2**(e-18)   -- general case with k = 9
                xn = (xn + a / xn) >> 1; // ε_4 := | x_4 - sqrt(a) | ≤ 2**(e-36)   -- general case with k = 18
                xn = (xn + a / xn) >> 1; // ε_5 := | x_5 - sqrt(a) | ≤ 2**(e-72)   -- general case with k = 36
                xn = (xn + a / xn) >> 1; // ε_6 := | x_6 - sqrt(a) | ≤ 2**(e-144)  -- general case with k = 72

                // Because e ≤ 128 (as discussed during the first estimation phase), we know have reached a precision
                // ε_6 ≤ 2**(e-144) < 1. Given we're operating on integers, then we can ensure that xn is now either
                // sqrt(a) or sqrt(a) + 1.
                return xn - SafeCast.toUint(xn > a / xn);
            }
        }

        /**
        * @dev Calculates sqrt(a), following the selected rounding direction.
        */
        function sqrt(uint256 a, Rounding rounding) internal pure returns (uint256) {
            unchecked {
                uint256 result = sqrt(a);
                return result + SafeCast.toUint(unsignedRoundsUp(rounding) && result * result < a);
            }
        }

        /**
        * @dev Return the log in base 2 of a positive value rounded towards zero.
        * Returns 0 if given 0.
        */
        function log2(uint256 value) internal pure returns (uint256) {
            uint256 result = 0;
            uint256 exp;
            unchecked {
                exp = 128 * SafeCast.toUint(value > (1 << 128) - 1);
                value >>= exp;
                result += exp;

                exp = 64 * SafeCast.toUint(value > (1 << 64) - 1);
                value >>= exp;
                result += exp;

                exp = 32 * SafeCast.toUint(value > (1 << 32) - 1);
                value >>= exp;
                result += exp;

                exp = 16 * SafeCast.toUint(value > (1 << 16) - 1);
                value >>= exp;
                result += exp;

                exp = 8 * SafeCast.toUint(value > (1 << 8) - 1);
                value >>= exp;
                result += exp;

                exp = 4 * SafeCast.toUint(value > (1 << 4) - 1);
                value >>= exp;
                result += exp;

                exp = 2 * SafeCast.toUint(value > (1 << 2) - 1);
                value >>= exp;
                result += exp;

                result += SafeCast.toUint(value > 1);
            }
            return result;
        }

        /**
        * @dev Return the log in base 2, following the selected rounding direction, of a positive value.
        * Returns 0 if given 0.
        */
        function log2(uint256 value, Rounding rounding) internal pure returns (uint256) {
            unchecked {
                uint256 result = log2(value);
                return result + SafeCast.toUint(unsignedRoundsUp(rounding) && 1 << result < value);
            }
        }

        /**
        * @dev Return the log in base 10 of a positive value rounded towards zero.
        * Returns 0 if given 0.
        */
        function log10(uint256 value) internal pure returns (uint256) {
            uint256 result = 0;
            unchecked {
                if (value >= 10 ** 64) {
                    value /= 10 ** 64;
                    result += 64;
                }
                if (value >= 10 ** 32) {
                    value /= 10 ** 32;
                    result += 32;
                }
                if (value >= 10 ** 16) {
                    value /= 10 ** 16;
                    result += 16;
                }
                if (value >= 10 ** 8) {
                    value /= 10 ** 8;
                    result += 8;
                }
                if (value >= 10 ** 4) {
                    value /= 10 ** 4;
                    result += 4;
                }
                if (value >= 10 ** 2) {
                    value /= 10 ** 2;
                    result += 2;
                }
                if (value >= 10 ** 1) {
                    result += 1;
                }
            }
            return result;
        }

        /**
        * @dev Return the log in base 10, following the selected rounding direction, of a positive value.
        * Returns 0 if given 0.
        */
        function log10(uint256 value, Rounding rounding) internal pure returns (uint256) {
            unchecked {
                uint256 result = log10(value);
                return result + SafeCast.toUint(unsignedRoundsUp(rounding) && 10 ** result < value);
            }
        }

        /**
        * @dev Return the log in base 256 of a positive value rounded towards zero.
        * Returns 0 if given 0.
        *
        * Adding one to the result gives the number of pairs of hex symbols needed to represent `value` as a hex string.
        */
        function log256(uint256 value) internal pure returns (uint256) {
            uint256 result = 0;
            uint256 isGt;
            unchecked {
                isGt = SafeCast.toUint(value > (1 << 128) - 1);
                value >>= isGt * 128;
                result += isGt * 16;

                isGt = SafeCast.toUint(value > (1 << 64) - 1);
                value >>= isGt * 64;
                result += isGt * 8;

                isGt = SafeCast.toUint(value > (1 << 32) - 1);
                value >>= isGt * 32;
                result += isGt * 4;

                isGt = SafeCast.toUint(value > (1 << 16) - 1);
                value >>= isGt * 16;
                result += isGt * 2;

                result += SafeCast.toUint(value > (1 << 8) - 1);
            }
            return result;
        }

        /**
        * @dev Return the log in base 256, following the selected rounding direction, of a positive value.
        * Returns 0 if given 0.
        */
        function log256(uint256 value, Rounding rounding) internal pure returns (uint256) {
            unchecked {
                uint256 result = log256(value);
                return result + SafeCast.toUint(unsignedRoundsUp(rounding) && 1 << (result << 3) < value);
            }
        }

        /**
        * @dev Returns whether a provided rounding mode is considered rounding up for unsigned integers.
        */
        function unsignedRoundsUp(Rounding rounding) internal pure returns (bool) {
            return uint8(rounding) % 2 == 1;
        }
    }


    // File openzeppelin-contracts/contracts/utils/math/SignedMath.sol

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (utils/math/SignedMath.sol)

    //pragma solidity ^0.8.20;

    /**
    * @dev Standard signed math utilities missing in the Solidity language.
    */
    library SignedMath {
        /**
        * @dev Returns the largest of two signed numbers.
        */
        function max(int256 a, int256 b) internal pure returns (int256) {
            return a > b ? a : b;
        }

        /**
        * @dev Returns the smallest of two signed numbers.
        */
        function min(int256 a, int256 b) internal pure returns (int256) {
            return a < b ? a : b;
        }

        /**
        * @dev Returns the average of two signed numbers without overflow.
        * The result is rounded towards zero.
        */
        function average(int256 a, int256 b) internal pure returns (int256) {
            // Formula from the book "Hacker's Delight"
            int256 x = (a & b) + ((a ^ b) >> 1);
            return x + (int256(uint256(x) >> 255) & (a ^ b));
        }

        /**
        * @dev Returns the absolute unsigned value of a signed value.
        */
        function abs(int256 n) internal pure returns (uint256) {
            unchecked {
                // Formula from the "Bit Twiddling Hacks" by Sean Eron Anderson.
                // Since `n` is a signed integer, the generated bytecode will use the SAR opcode to perform the right shift,
                // taking advantage of the most significant (or "sign" bit) in two's complement representation.
                // This opcode adds new most significant bits set to the value of the previous most significant bit. As a result,
                // the mask will either be `bytes(0)` (if n is positive) or `~bytes32(0)` (if n is negative).
                int256 mask = n >> 255;

                // A `bytes(0)` mask leaves the input unchanged, while a `~bytes32(0)` mask complements it.
                return uint256((n + mask) ^ mask);
            }
        }
    }


    // File openzeppelin-contracts/contracts/utils/Strings.sol

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (utils/Strings.sol)

    //pragma solidity ^0.8.20;
    /**
    * @dev String operations.
    */
    library Strings {
        bytes16 private constant HEX_DIGITS = "0123456789abcdef";
        uint8 private constant ADDRESS_LENGTH = 20;

        /**
        * @dev The `value` string doesn't fit in the specified `length`.
        */
        error StringsInsufficientHexLength(uint256 value, uint256 length);

        /**
        * @dev Converts a `uint256` to its ASCII `string` decimal representation.
        */
        function toString(uint256 value) internal pure returns (string memory) {
            unchecked {
                uint256 length = Math.log10(value) + 1;
                string memory buffer = new string(length);
                uint256 ptr;
                /// @solidity memory-safe-assembly
                assembly {
                    ptr := add(buffer, add(32, length))
                }
                while (true) {
                    ptr--;
                    /// @solidity memory-safe-assembly
                    assembly {
                        mstore8(ptr, byte(mod(value, 10), HEX_DIGITS))
                    }
                    value /= 10;
                    if (value == 0) break;
                }
                return buffer;
            }
        }

        /**
        * @dev Converts a `int256` to its ASCII `string` decimal representation.
        */
        function toStringSigned(int256 value) internal pure returns (string memory) {
            return string.concat(value < 0 ? "-" : "", toString(SignedMath.abs(value)));
        }

        /**
        * @dev Converts a `uint256` to its ASCII `string` hexadecimal representation.
        */
        function toHexString(uint256 value) internal pure returns (string memory) {
            unchecked {
                return toHexString(value, Math.log256(value) + 1);
            }
        }

        /**
        * @dev Converts a `uint256` to its ASCII `string` hexadecimal representation with fixed length.
        */
        function toHexString(uint256 value, uint256 length) internal pure returns (string memory) {
            uint256 localValue = value;
            bytes memory buffer = new bytes(2 * length + 2);
            buffer[0] = "0";
            buffer[1] = "x";
            for (uint256 i = 2 * length + 1; i > 1; --i) {
                buffer[i] = HEX_DIGITS[localValue & 0xf];
                localValue >>= 4;
            }
            if (localValue != 0) {
                revert StringsInsufficientHexLength(value, length);
            }
            return string(buffer);
        }

        /**
        * @dev Converts an `address` with fixed length of 20 bytes to its not checksummed ASCII `string` hexadecimal
        * representation.
        */
        function toHexString(address addr) internal pure returns (string memory) {
            return toHexString(uint256(uint160(addr)), ADDRESS_LENGTH);
        }

        /**
        * @dev Returns true if the two strings are equal.
        */
        function equal(string memory a, string memory b) internal pure returns (bool) {
            return bytes(a).length == bytes(b).length && keccak256(bytes(a)) == keccak256(bytes(b));
        }
    }


    // File openzeppelin-contracts/contracts/utils/cryptography/MessageHashUtils.sol

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (utils/cryptography/MessageHashUtils.sol)

    //pragma solidity ^0.8.20;
    /**
    * @dev Signature message hash utilities for producing digests to be consumed by {ECDSA} recovery or signing.
    *
    * The library provides methods for generating a hash of a message that conforms to the
    * https://eips.ethereum.org/EIPS/eip-191[ERC-191] and https://eips.ethereum.org/EIPS/eip-712[EIP 712]
    * specifications.
    */
    library MessageHashUtils {
        /**
        * @dev Returns the keccak256 digest of an ERC-191 signed data with version
        * `0x45` (`personal_sign` messages).
        *
        * The digest is calculated by prefixing a bytes32 `messageHash` with
        * `"\x19Ethereum Signed Message:\n32"` and hashing the result. It corresponds with the
        * hash signed when using the https://eth.wiki/json-rpc/API#eth_sign[`eth_sign`] JSON-RPC method.
        *
        * NOTE: The `messageHash` parameter is intended to be the result of hashing a raw message with
        * keccak256, although any bytes32 value can be safely used because the final digest will
        * be re-hashed.
        *
        * See {ECDSA-recover}.
        */
        function toEthSignedMessageHash(bytes32 messageHash) internal pure returns (bytes32 digest) {
            /// @solidity memory-safe-assembly
            assembly {
                mstore(0x00, "\x19Ethereum Signed Message:\n32") // 32 is the bytes-length of messageHash
                mstore(0x1c, messageHash) // 0x1c (28) is the length of the prefix
                digest := keccak256(0x00, 0x3c) // 0x3c is the length of the prefix (0x1c) + messageHash (0x20)
            }
        }

        /**
        * @dev Returns the keccak256 digest of an ERC-191 signed data with version
        * `0x45` (`personal_sign` messages).
        *
        * The digest is calculated by prefixing an arbitrary `message` with
        * `"\x19Ethereum Signed Message:\n" + len(message)` and hashing the result. It corresponds with the
        * hash signed when using the https://eth.wiki/json-rpc/API#eth_sign[`eth_sign`] JSON-RPC method.
        *
        * See {ECDSA-recover}.
        */
        function toEthSignedMessageHash(bytes memory message) internal pure returns (bytes32) {
            return
                keccak256(bytes.concat("\x19Ethereum Signed Message:\n", bytes(Strings.toString(message.length)), message));
        }

        /**
        * @dev Returns the keccak256 digest of an ERC-191 signed data with version
        * `0x00` (data with intended validator).
        *
        * The digest is calculated by prefixing an arbitrary `data` with `"\x19\x00"` and the intended
        * `validator` address. Then hashing the result.
        *
        * See {ECDSA-recover}.
        */
        function toDataWithIntendedValidatorHash(address validator, bytes memory data) internal pure returns (bytes32) {
            return keccak256(abi.encodePacked(hex"19_00", validator, data));
        }

        /**
        * @dev Returns the keccak256 digest of an EIP-712 typed data (ERC-191 version `0x01`).
        *
        * The digest is calculated from a `domainSeparator` and a `structHash`, by prefixing them with
        * `\x19\x01` and hashing the result. It corresponds to the hash signed by the
        * https://eips.ethereum.org/EIPS/eip-712[`eth_signTypedData`] JSON-RPC method as part of EIP-712.
        *
        * See {ECDSA-recover}.
        */
        function toTypedDataHash(bytes32 domainSeparator, bytes32 structHash) internal pure returns (bytes32 digest) {
            /// @solidity memory-safe-assembly
            assembly {
                let ptr := mload(0x40)
                mstore(ptr, hex"19_01")
                mstore(add(ptr, 0x02), domainSeparator)
                mstore(add(ptr, 0x22), structHash)
                digest := keccak256(ptr, 0x42)
            }
        }
    }


    type ShortString is bytes32;

    /**
    * @dev This library provides functions to convert short memory strings
    * into a `ShortString` type that can be used as an immutable variable.
    *
    * Strings of arbitrary length can be optimized using this library if
    * they are short enough (up to 31 bytes) by packing them with their
    * length (1 byte) in a single EVM word (32 bytes). Additionally, a
    * fallback mechanism can be used for every other case.
    *
    * Usage example:
    *
    * ```solidity
    * contract Named {
    *     using ShortStrings for *;
    *
    *     ShortString private immutable _name;
    *     string private _nameFallback;
    *
    *     constructor(string memory contractName) {
    *         _name = contractName.toShortStringWithFallback(_nameFallback);
    *     }
    *
    *     function name() external view returns (string memory) {
    *         return _name.toStringWithFallback(_nameFallback);
    *     }
    * }
    * ```
    */
    library ShortStrings {
        // Used as an identifier for strings longer than 31 bytes.
        bytes32 private constant FALLBACK_SENTINEL = 0x00000000000000000000000000000000000000000000000000000000000000FF;

        error StringTooLong(string str);
        error InvalidShortString();

        /**
        * @dev Encode a string of at most 31 chars into a `ShortString`.
        *
        * This will trigger a `StringTooLong` error is the input string is too long.
        */
        function toShortString(string memory str) internal pure returns (ShortString) {
            bytes memory bstr = bytes(str);
            if (bstr.length > 31) {
                revert StringTooLong(str);
            }
            return ShortString.wrap(bytes32(uint256(bytes32(bstr)) | bstr.length));
        }

        /**
        * @dev Decode a `ShortString` back to a "normal" string.
        */
        function toString(ShortString sstr) internal pure returns (string memory) {
            uint256 len = byteLength(sstr);
            // using `new string(len)` would work locally but is not memory safe.
            string memory str = new string(32);
            /// @solidity memory-safe-assembly
            assembly {
                mstore(str, len)
                mstore(add(str, 0x20), sstr)
            }
            return str;
        }

        /**
        * @dev Return the length of a `ShortString`.
        */
        function byteLength(ShortString sstr) internal pure returns (uint256) {
            uint256 result = uint256(ShortString.unwrap(sstr)) & 0xFF;
            if (result > 31) {
                revert InvalidShortString();
            }
            return result;
        }

        /**
        * @dev Encode a string into a `ShortString`, or write it to storage if it is too long.
        */
        function toShortStringWithFallback(string memory value, string storage store) internal returns (ShortString) {
            if (bytes(value).length < 32) {
                return toShortString(value);
            } else {
                StorageSlot.getStringSlot(store).value = value;
                return ShortString.wrap(FALLBACK_SENTINEL);
            }
        }

        /**
        * @dev Decode a string that was encoded to `ShortString` or written to storage using {setWithFallback}.
        */
        function toStringWithFallback(ShortString value, string storage store) internal pure returns (string memory) {
            if (ShortString.unwrap(value) != FALLBACK_SENTINEL) {
                return toString(value);
            } else {
                return store;
            }
        }

        /**
        * @dev Return the length of a string that was encoded to `ShortString` or written to storage using
        * {setWithFallback}.
        *
        * WARNING: This will return the "byte length" of the string. This may not reflect the actual length in terms of
        * actual characters as the UTF-8 encoding of a single character can span over multiple bytes.
        */
        function byteLengthWithFallback(ShortString value, string storage store) internal view returns (uint256) {
            if (ShortString.unwrap(value) != FALLBACK_SENTINEL) {
                return byteLength(value);
            } else {
                return bytes(store).length;
            }
        }
    }


    // File openzeppelin-contracts/contracts/utils/cryptography/EIP712.sol

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v5.0.0) (utils/cryptography/EIP712.sol)

    //pragma solidity ^0.8.20;
    /**
    * @dev https://eips.ethereum.org/EIPS/eip-712[EIP-712] is a standard for hashing and signing of typed structured data.
    *
    * The encoding scheme specified in the EIP requires a domain separator and a hash of the typed structured data, whose
    * encoding is very generic and therefore its implementation in Solidity is not feasible, thus this contract
    * does not implement the encoding itself. Protocols need to implement the type-specific encoding they need in order to
    * produce the hash of their typed data using a combination of `abi.encode` and `keccak256`.
    *
    * This contract implements the EIP-712 domain separator ({_domainSeparatorV4}) that is used as part of the encoding
    * scheme, and the final step of the encoding to obtain the message digest that is then signed via ECDSA
    * ({_hashTypedDataV4}).
    *
    * The implementation of the domain separator was designed to be as efficient as possible while still properly updating
    * the chain id to protect against replay attacks on an eventual fork of the chain.
    *
    * NOTE: This contract implements the version of the encoding known as "v4", as implemented by the JSON RPC method
    * https://docs.metamask.io/guide/signing-data.html[`eth_signTypedDataV4` in MetaMask].
    *
    * NOTE: In the upgradeable version of this contract, the cached values will correspond to the address, and the domain
    * separator of the implementation contract. This will cause the {_domainSeparatorV4} function to always rebuild the
    * separator from the immutable values, which is cheaper than accessing a cached version in cold storage.
    *
    * @custom:oz-upgrades-unsafe-allow state-variable-immutable
    */
    abstract contract EIP712 is IERC5267 {
        using ShortStrings for *;

        bytes32 private constant TYPE_HASH =
            keccak256("EIP712Domain(string name,string version,uint256 chainId,address verifyingContract)");

        // Cache the domain separator as an immutable value, but also store the chain id that it corresponds to, in order to
        // invalidate the cached domain separator if the chain id changes.
        bytes32 private immutable _cachedDomainSeparator;
        uint256 private immutable _cachedChainId;
        address private immutable _cachedThis;

        bytes32 private immutable _hashedName;
        bytes32 private immutable _hashedVersion;

        ShortString private immutable _name;
        ShortString private immutable _version;
        string private _nameFallback;
        string private _versionFallback;

        /**
        * @dev Initializes the domain separator and parameter caches.
        *
        * The meaning of `name` and `version` is specified in
        * https://eips.ethereum.org/EIPS/eip-712#definition-of-domainseparator[EIP-712]:
        *
        * - `name`: the user readable name of the signing domain, i.e. the name of the DApp or the protocol.
        * - `version`: the current major version of the signing domain.
        *
        * NOTE: These parameters cannot be changed except through a xref:learn::upgrading-smart-contracts.adoc[smart
        * contract upgrade].
        */
        constructor(string memory name, string memory version) {
            _name = name.toShortStringWithFallback(_nameFallback);
            _version = version.toShortStringWithFallback(_versionFallback);
            _hashedName = keccak256(bytes(name));
            _hashedVersion = keccak256(bytes(version));

            _cachedChainId = block.chainid;
            _cachedDomainSeparator = _buildDomainSeparator();
            _cachedThis = address(this);
        }

        /**
        * @dev Returns the domain separator for the current chain.
        */
        function _domainSeparatorV4() internal view returns (bytes32) {
            if (address(this) == _cachedThis && block.chainid == _cachedChainId) {
                return _cachedDomainSeparator;
            } else {
                return _buildDomainSeparator();
            }
        }

        function _buildDomainSeparator() private view returns (bytes32) {
            return keccak256(abi.encode(TYPE_HASH, _hashedName, _hashedVersion, block.chainid, address(this)));
        }

        /**
        * @dev Given an already https://eips.ethereum.org/EIPS/eip-712#definition-of-hashstruct[hashed struct], this
        * function returns the hash of the fully encoded EIP712 message for this domain.
        *
        * This hash can be used together with {ECDSA-recover} to obtain the signer of a message. For example:
        *
        * ```solidity
        * bytes32 digest = _hashTypedDataV4(keccak256(abi.encode(
        *     keccak256("Mail(address to,string contents)"),
        *     mailTo,
        *     keccak256(bytes(mailContents))
        * )));
        * address signer = ECDSA.recover(digest, signature);
        * ```
        */
        function _hashTypedDataV4(bytes32 structHash) internal view virtual returns (bytes32) {
            return MessageHashUtils.toTypedDataHash(_domainSeparatorV4(), structHash);
        }

        /**
        * @dev See {IERC-5267}.
        */
        function eip712Domain()
            public
            view
            virtual
            returns (
                bytes1 fields,
                string memory name,
                string memory version,
                uint256 chainId,
                address verifyingContract,
                bytes32 salt,
                uint256[] memory extensions
            )
        {
            return (
                hex"0f", // 01111
                _EIP712Name(),
                _EIP712Version(),
                block.chainid,
                address(this),
                bytes32(0),
                new uint256[](0)
            );
        }

        /**
        * @dev The name parameter for the EIP712 domain.
        *
        * NOTE: By default this function reads _name which is an immutable value.
        * It only reads from storage if necessary (in case the value is too large to fit in a ShortString).
        */
        // solhint-disable-next-line func-name-mixedcase
        function _EIP712Name() internal view returns (string memory) {
            return _name.toStringWithFallback(_nameFallback);
        }

        /**
        * @dev The version parameter for the EIP712 domain.
        *
        * NOTE: By default this function reads _version which is an immutable value.
        * It only reads from storage if necessary (in case the value is too large to fit in a ShortString).
        */
        // solhint-disable-next-line func-name-mixedcase
        function _EIP712Version() internal view returns (string memory) {
            return _version.toStringWithFallback(_versionFallback);
        }
    }


    // File openzeppelin-contracts/contracts/metatx/MinimalForwarder.sol

    // Original license: SPDX_License_Identifier: MIT
    // OpenZeppelin Contracts (last updated v4.9.0) (metatx/MinimalForwarder.sol)

    //pragma solidity ^0.8.0;
    /**
    * @dev Simple minimal forwarder to be used together with an ERC2771 compatible contract. See {ERC2771Context}.
    *
    * MinimalForwarder is mainly meant for testing, as it is missing features to be a good production-ready forwarder. This
    * contract does not intend to have all the properties that are needed for a sound forwarding system. A fully
    * functioning forwarding system with good properties requires more complexity. We suggest you look at other projects
    * such as the GSN which do have the goal of building a system like that.
    */
    contract MinimalForwarder is EIP712 {
        using ECDSA for bytes32;

        struct ForwardRequest {
            address from;
            address to;
            uint256 value;
            uint256 gas;
            uint256 nonce;
            bytes data;
        }

        bytes32 private constant _TYPEHASH =
            keccak256("ForwardRequest(address from,address to,uint256 value,uint256 gas,uint256 nonce,bytes data)");

        mapping(address => uint256) private _nonces;

        constructor() EIP712("MinimalForwarder", "0.0.1") {}

        function getNonce(address from) public view returns (uint256) {
            return _nonces[from];
        }

        function verify(ForwardRequest calldata req, bytes calldata signature) public view returns (bool) {
            address signer = _hashTypedDataV4(
                keccak256(abi.encode(_TYPEHASH, req.from, req.to, req.value, req.gas, req.nonce, keccak256(req.data)))
            ).recover(signature);
            return _nonces[req.from] == req.nonce && signer == req.from;
        }

        function execute(
            ForwardRequest calldata req,
            bytes calldata signature
        ) public payable returns (bool, bytes memory) {
            require(verify(req, signature), "MinimalForwarder: signature does not match request");
            _nonces[req.from] = req.nonce + 1;

            (bool success, bytes memory returndata) = req.to.call{gas: req.gas, value: req.value}(
                abi.encodePacked(req.data, req.from)
            );

            // Validate that the relayer has sent enough gas for the call.
            // See https://ronan.eth.limo/blog/ethereum-gas-dangers/
            if (gasleft() <= req.gas / 63) {
                // We explicitly trigger invalid opcode to consume all gas and bubble-up the effects, since
                // neither revert or assert consume all gas since Solidity 0.8.0
                // https://docs.soliditylang.org/en/v0.8.0/control-structures.html#panic-via-assert-and-error-via-require
                /// @solidity memory-safe-assembly
                assembly {
                    invalid()
                }
            }

            return (success, returndata);
        }
    }


    // File contracts/exchange.sol

    // Original license: SPDX_License_Identifier: MIT
    //pragma solidity ^0.8.9;
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
