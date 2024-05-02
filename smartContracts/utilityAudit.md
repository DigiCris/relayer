Summary
 - [unused-return](#unused-return) (2 results) (Medium)
 - [assembly](#assembly) (13 results) (Informational)
 - [dead-code](#dead-code) (31 results) (Informational)
 - [solc-version](#solc-version) (1 results) (Informational)
 - [low-level-calls](#low-level-calls) (4 results) (Informational)
 - [naming-convention](#naming-convention) (22 results) (Informational)
## unused-return
Impact: Medium
Confidence: Medium
 - [ ] ID-0
[ERC1967Utils.upgradeToAndCall(address,bytes)](contracts/utility.sol#L1095-L1104) ignores return value by [Address.functionDelegateCall(newImplementation,data)](contracts/utility.sol#L1100)

contracts/utility.sol#L1095-L1104


 - [ ] ID-1
[ERC1967Utils.upgradeBeaconToAndCall(address,bytes)](contracts/utility.sol#L1185-L1194) ignores return value by [Address.functionDelegateCall(IBeacon(newBeacon).implementation(),data)](contracts/utility.sol#L1190)

contracts/utility.sol#L1185-L1194


## assembly
Impact: Informational
Confidence: High
 - [ ] ID-2
[StorageSlot.getBytesSlot(bytes)](contracts/utility.sol#L1004-L1009) uses assembly
	- [INLINE ASM](contracts/utility.sol#L1006-L1008)

contracts/utility.sol#L1004-L1009


 - [ ] ID-3
[StorageSlot.getStringSlot(string)](contracts/utility.sol#L984-L989) uses assembly
	- [INLINE ASM](contracts/utility.sol#L986-L988)

contracts/utility.sol#L984-L989


 - [ ] ID-4
[Address._revert(bytes)](contracts/utility.sol#L858-L870) uses assembly
	- [INLINE ASM](contracts/utility.sol#L863-L866)

contracts/utility.sol#L858-L870


 - [ ] ID-5
[StorageSlot.getStringSlot(bytes32)](contracts/utility.sol#L974-L979) uses assembly
	- [INLINE ASM](contracts/utility.sol#L976-L978)

contracts/utility.sol#L974-L979


 - [ ] ID-6
[StorageSlot.getBytes32Slot(bytes32)](contracts/utility.sol#L954-L959) uses assembly
	- [INLINE ASM](contracts/utility.sol#L956-L958)

contracts/utility.sol#L954-L959


 - [ ] ID-7
[StorageSlot.getBytesSlot(bytes32)](contracts/utility.sol#L994-L999) uses assembly
	- [INLINE ASM](contracts/utility.sol#L996-L998)

contracts/utility.sol#L994-L999


 - [ ] ID-8
[StorageSlot.getAddressSlot(bytes32)](contracts/utility.sol#L934-L939) uses assembly
	- [INLINE ASM](contracts/utility.sol#L936-L938)

contracts/utility.sol#L934-L939


 - [ ] ID-9
[StorageSlot.getUint256Slot(bytes32)](contracts/utility.sol#L964-L969) uses assembly
	- [INLINE ASM](contracts/utility.sol#L966-L968)

contracts/utility.sol#L964-L969


 - [ ] ID-10
[Initializable._getInitializableStorage()](contracts/utility.sol#L221-L225) uses assembly
	- [INLINE ASM](contracts/utility.sol#L222-L224)

contracts/utility.sol#L221-L225


 - [ ] ID-11
[StorageSlot.getBooleanSlot(bytes32)](contracts/utility.sol#L944-L949) uses assembly
	- [INLINE ASM](contracts/utility.sol#L946-L948)

contracts/utility.sol#L944-L949


 - [ ] ID-12
[ERC20Upgradeable._getERC20Storage()](contracts/utility.sol#L1689-L1693) uses assembly
	- [INLINE ASM](contracts/utility.sol#L1690-L1692)

contracts/utility.sol#L1689-L1693


 - [ ] ID-13
[PausableUpgradeable._getPausableStorage()](contracts/utility.sol#L2008-L2012) uses assembly
	- [INLINE ASM](contracts/utility.sol#L2009-L2011)

contracts/utility.sol#L2008-L2012


 - [ ] ID-14
[AccessControlUpgradeable._getAccessControlStorage()](contracts/utility.sol#L498-L502) uses assembly
	- [INLINE ASM](contracts/utility.sol#L499-L501)

contracts/utility.sol#L498-L502


## dead-code
Impact: Informational
Confidence: Medium
 - [ ] ID-15
[ERC20PausableUpgradeable.__ERC20Pausable_init_unchained()](contracts/utility.sol#L2151-L2152) is never used and should be removed

contracts/utility.sol#L2151-L2152


 - [ ] ID-16
[ContextUpgradeable._msgData()](contracts/utility.sol#L256-L258) is never used and should be removed

contracts/utility.sol#L256-L258


 - [ ] ID-17
[ERC1967Utils._setAdmin(address)](contracts/utility.sol#L1127-L1132) is never used and should be removed

contracts/utility.sol#L1127-L1132


 - [ ] ID-18
[StorageSlot.getBytesSlot(bytes)](contracts/utility.sol#L1004-L1009) is never used and should be removed

contracts/utility.sol#L1004-L1009


 - [ ] ID-19
[Address.sendValue(address,uint256)](contracts/utility.sol#L753-L762) is never used and should be removed

contracts/utility.sol#L753-L762


 - [ ] ID-20
[Address.functionCallWithValue(address,bytes,uint256)](contracts/utility.sol#L795-L801) is never used and should be removed

contracts/utility.sol#L795-L801


 - [ ] ID-21
[ContextUpgradeable._contextSuffixLength()](contracts/utility.sol#L260-L262) is never used and should be removed

contracts/utility.sol#L260-L262


 - [ ] ID-22
[StorageSlot.getUint256Slot(bytes32)](contracts/utility.sol#L964-L969) is never used and should be removed

contracts/utility.sol#L964-L969


 - [ ] ID-23
[ERC1967Utils.upgradeBeaconToAndCall(address,bytes)](contracts/utility.sol#L1185-L1194) is never used and should be removed

contracts/utility.sol#L1185-L1194


 - [ ] ID-24
[StorageSlot.getStringSlot(bytes32)](contracts/utility.sol#L974-L979) is never used and should be removed

contracts/utility.sol#L974-L979


 - [ ] ID-25
[ERC1967Utils.getAdmin()](contracts/utility.sol#L1120-L1122) is never used and should be removed

contracts/utility.sol#L1120-L1122


 - [ ] ID-26
[ContextUpgradeable.__Context_init_unchained()](contracts/utility.sol#L250-L251) is never used and should be removed

contracts/utility.sol#L250-L251


 - [ ] ID-27
[ERC165Upgradeable.__ERC165_init_unchained()](contracts/utility.sol#L319-L320) is never used and should be removed

contracts/utility.sol#L319-L320


 - [ ] ID-28
[ERC1967Utils.getBeacon()](contracts/utility.sol#L1154-L1156) is never used and should be removed

contracts/utility.sol#L1154-L1156


 - [ ] ID-29
[PausableUpgradeable.__Pausable_init()](contracts/utility.sol#L2037-L2039) is never used and should be removed

contracts/utility.sol#L2037-L2039


 - [ ] ID-30
[ERC1967Utils._setBeacon(address)](contracts/utility.sol#L1161-L1172) is never used and should be removed

contracts/utility.sol#L1161-L1172


 - [ ] ID-31
[AccessControlUpgradeable._setRoleAdmin(bytes32,bytes32)](contracts/utility.sol#L622-L627) is never used and should be removed

contracts/utility.sol#L622-L627


 - [ ] ID-32
[Address.functionStaticCall(address,bytes)](contracts/utility.sol#L807-L810) is never used and should be removed

contracts/utility.sol#L807-L810


 - [ ] ID-33
[ERC165Upgradeable.__ERC165_init()](contracts/utility.sol#L316-L317) is never used and should be removed

contracts/utility.sol#L316-L317


 - [ ] ID-34
[ERC20Upgradeable._burn(address,uint256)](contracts/utility.sol#L1903-L1908) is never used and should be removed

contracts/utility.sol#L1903-L1908


 - [ ] ID-35
[UUPSUpgradeable.__UUPSUpgradeable_init_unchained()](contracts/utility.sol#L1275-L1276) is never used and should be removed

contracts/utility.sol#L1275-L1276


 - [ ] ID-36
[ERC1967Utils.changeAdmin(address)](contracts/utility.sol#L1139-L1142) is never used and should be removed

contracts/utility.sol#L1139-L1142


 - [ ] ID-37
[StorageSlot.getStringSlot(string)](contracts/utility.sol#L984-L989) is never used and should be removed

contracts/utility.sol#L984-L989


 - [ ] ID-38
[AccessControlUpgradeable.__AccessControl_init_unchained()](contracts/utility.sol#L516-L517) is never used and should be removed

contracts/utility.sol#L516-L517


 - [ ] ID-39
[Initializable._getInitializedVersion()](contracts/utility.sol#L206-L208) is never used and should be removed

contracts/utility.sol#L206-L208


 - [ ] ID-40
[StorageSlot.getBooleanSlot(bytes32)](contracts/utility.sol#L944-L949) is never used and should be removed

contracts/utility.sol#L944-L949


 - [ ] ID-41
[StorageSlot.getBytes32Slot(bytes32)](contracts/utility.sol#L954-L959) is never used and should be removed

contracts/utility.sol#L954-L959


 - [ ] ID-42
[Address.verifyCallResult(bool,bytes)](contracts/utility.sol#L847-L853) is never used and should be removed

contracts/utility.sol#L847-L853


 - [ ] ID-43
[ContextUpgradeable.__Context_init()](contracts/utility.sol#L247-L248) is never used and should be removed

contracts/utility.sol#L247-L248


 - [ ] ID-44
[StorageSlot.getBytesSlot(bytes32)](contracts/utility.sol#L994-L999) is never used and should be removed

contracts/utility.sol#L994-L999


 - [ ] ID-45
[Address.functionCall(address,bytes)](contracts/utility.sol#L782-L784) is never used and should be removed

contracts/utility.sol#L782-L784


## solc-version
Impact: Informational
Confidence: High
 - [ ] ID-46
Version constraint ^0.8.20 contains known severe issues (https://solidity.readthedocs.io/en/latest/bugs.html)
	- VerbatimInvalidDeduplication
	- FullInlinerNonExpressionSplitArgumentEvaluationOrder
	- MissingSideEffectsOnSelectorAccess.
 It is used by:
	- contracts/utility.sol#2

## low-level-calls
Impact: Informational
Confidence: High
 - [ ] ID-47
Low level call in [Address.functionStaticCall(address,bytes)](contracts/utility.sol#L807-L810):
	- [(success,returndata) = target.staticcall(data)](contracts/utility.sol#L808)

contracts/utility.sol#L807-L810


 - [ ] ID-48
Low level call in [Address.functionCallWithValue(address,bytes,uint256)](contracts/utility.sol#L795-L801):
	- [(success,returndata) = target.call{value: value}(data)](contracts/utility.sol#L799)

contracts/utility.sol#L795-L801


 - [ ] ID-49
Low level call in [Address.sendValue(address,uint256)](contracts/utility.sol#L753-L762):
	- [(success,None) = recipient.call{value: amount}()](contracts/utility.sol#L758)

contracts/utility.sol#L753-L762


 - [ ] ID-50
Low level call in [Address.functionDelegateCall(address,bytes)](contracts/utility.sol#L816-L819):
	- [(success,returndata) = target.delegatecall(data)](contracts/utility.sol#L817)

contracts/utility.sol#L816-L819


## naming-convention
Impact: Informational
Confidence: High
 - [ ] ID-51
Constant [AccessControlUpgradeable.AccessControlStorageLocation](contracts/utility.sol#L496) is not in UPPER_CASE_WITH_UNDERSCORES

contracts/utility.sol#L496


 - [ ] ID-52
Function [AccessControlUpgradeable.__AccessControl_init_unchained()](contracts/utility.sol#L516-L517) is not in mixedCase

contracts/utility.sol#L516-L517


 - [ ] ID-53
Parameter [Utility.setExchange(address)._exchange](contracts/utility.sol#L2233) is not in mixedCase

contracts/utility.sol#L2233


 - [ ] ID-54
Parameter [UtilityOverride._Utility_initialize(string,string)._symbol](contracts/utility.sol#L2198) is not in mixedCase

contracts/utility.sol#L2198


 - [ ] ID-55
Function [UtilityOverride._Utility_initialize(string,string)](contracts/utility.sol#L2198-L2208) is not in mixedCase

contracts/utility.sol#L2198-L2208


 - [ ] ID-56
Function [ERC20Upgradeable.__ERC20_init_unchained(string,string)](contracts/utility.sol#L1705-L1709) is not in mixedCase

contracts/utility.sol#L1705-L1709


 - [ ] ID-57
Function [ERC20Upgradeable.__ERC20_init(string,string)](contracts/utility.sol#L1701-L1703) is not in mixedCase

contracts/utility.sol#L1701-L1703


 - [ ] ID-58
Function [ERC165Upgradeable.__ERC165_init_unchained()](contracts/utility.sol#L319-L320) is not in mixedCase

contracts/utility.sol#L319-L320


 - [ ] ID-59
Function [ContextUpgradeable.__Context_init_unchained()](contracts/utility.sol#L250-L251) is not in mixedCase

contracts/utility.sol#L250-L251


 - [ ] ID-60
Function [UUPSUpgradeable.__UUPSUpgradeable_init_unchained()](contracts/utility.sol#L1275-L1276) is not in mixedCase

contracts/utility.sol#L1275-L1276


 - [ ] ID-61
Function [ERC20PausableUpgradeable.__ERC20Pausable_init_unchained()](contracts/utility.sol#L2151-L2152) is not in mixedCase

contracts/utility.sol#L2151-L2152


 - [ ] ID-62
Function [AccessControlUpgradeable.__AccessControl_init()](contracts/utility.sol#L513-L514) is not in mixedCase

contracts/utility.sol#L513-L514


 - [ ] ID-63
Function [ERC20PausableUpgradeable.__ERC20Pausable_init()](contracts/utility.sol#L2147-L2149) is not in mixedCase

contracts/utility.sol#L2147-L2149


 - [ ] ID-64
Variable [UUPSUpgradeable.__self](contracts/utility.sol#L1229) is not in mixedCase

contracts/utility.sol#L1229


 - [ ] ID-65
Constant [ERC20Upgradeable.ERC20StorageLocation](contracts/utility.sol#L1687) is not in UPPER_CASE_WITH_UNDERSCORES

contracts/utility.sol#L1687


 - [ ] ID-66
Function [UUPSUpgradeable.__UUPSUpgradeable_init()](contracts/utility.sol#L1272-L1273) is not in mixedCase

contracts/utility.sol#L1272-L1273


 - [ ] ID-67
Function [PausableUpgradeable.__Pausable_init()](contracts/utility.sol#L2037-L2039) is not in mixedCase

contracts/utility.sol#L2037-L2039


 - [ ] ID-68
Parameter [UtilityOverride._Utility_initialize(string,string)._name](contracts/utility.sol#L2198) is not in mixedCase

contracts/utility.sol#L2198


 - [ ] ID-69
Function [ContextUpgradeable.__Context_init()](contracts/utility.sol#L247-L248) is not in mixedCase

contracts/utility.sol#L247-L248


 - [ ] ID-70
Function [ERC165Upgradeable.__ERC165_init()](contracts/utility.sol#L316-L317) is not in mixedCase

contracts/utility.sol#L316-L317


 - [ ] ID-71
Constant [PausableUpgradeable.PausableStorageLocation](contracts/utility.sol#L2006) is not in UPPER_CASE_WITH_UNDERSCORES

contracts/utility.sol#L2006


 - [ ] ID-72
Function [PausableUpgradeable.__Pausable_init_unchained()](contracts/utility.sol#L2041-L2044) is not in mixedCase

contracts/utility.sol#L2041-L2044


