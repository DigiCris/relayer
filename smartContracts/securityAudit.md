Summary
 - [arbitrary-send-eth](#arbitrary-send-eth) (1 results) (High)
 - [incorrect-exp](#incorrect-exp) (1 results) (High)
 - [divide-before-multiply](#divide-before-multiply) (9 results) (Medium)
 - [unused-return](#unused-return) (2 results) (Medium)
 - [return-bomb](#return-bomb) (1 results) (Low)
 - [timestamp](#timestamp) (1 results) (Low)
 - [assembly](#assembly) (26 results) (Informational)
 - [dead-code](#dead-code) (139 results) (Informational)
 - [solc-version](#solc-version) (1 results) (Informational)
 - [low-level-calls](#low-level-calls) (5 results) (Informational)
 - [naming-convention](#naming-convention) (59 results) (Informational)
 - [too-many-digits](#too-many-digits) (1 results) (Informational)
 - [unused-state](#unused-state) (12 results) (Informational)
## arbitrary-send-eth
Impact: High
Confidence: Medium
 - [ ] ID-0
[MinimalForwarder.execute(MinimalForwarder.ForwardRequest,bytes)](contracts/security.sol#L5204-L5228) sends eth to arbitrary user
	Dangerous calls:
	- [(success,returndata) = req.to.call{gas: req.gas,value: req.value}(abi.encodePacked(req.data,req.from))](contracts/security.sol#L5211-L5213)

contracts/security.sol#L5204-L5228


## incorrect-exp
Impact: High
Confidence: Medium
 - [ ] ID-1
[Math.mulDiv(uint256,uint256,uint256)](contracts/security.sol#L4119-L4198) has bitwise-xor operator ^ instead of the exponentiation operator **: 
	 - [inverse = (3 * denominator) ^ 2](contracts/security.sol#L4180)

contracts/security.sol#L4119-L4198


## divide-before-multiply
Impact: Medium
Confidence: Medium
 - [ ] ID-2
[Math.mulDiv(uint256,uint256,uint256)](contracts/security.sol#L4119-L4198) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/security.sol#L4165)
	- [inverse *= 2 - denominator * inverse](contracts/security.sol#L4189)

contracts/security.sol#L4119-L4198


 - [ ] ID-3
[Math.mulDiv(uint256,uint256,uint256)](contracts/security.sol#L4119-L4198) performs a multiplication on the result of a division:
	- [prod0 = prod0 / twos](contracts/security.sol#L4168)
	- [result = prod0 * inverse](contracts/security.sol#L4195)

contracts/security.sol#L4119-L4198


 - [ ] ID-4
[Math.invMod(uint256,uint256)](contracts/security.sol#L4218-L4264) performs a multiplication on the result of a division:
	- [quotient = gcd / remainder](contracts/security.sol#L4240)
	- [(gcd,remainder) = (remainder,gcd - remainder * quotient)](contracts/security.sol#L4242-L4249)

contracts/security.sol#L4218-L4264


 - [ ] ID-5
[Math.mulDiv(uint256,uint256,uint256)](contracts/security.sol#L4119-L4198) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/security.sol#L4165)
	- [inverse *= 2 - denominator * inverse](contracts/security.sol#L4186)

contracts/security.sol#L4119-L4198


 - [ ] ID-6
[Math.mulDiv(uint256,uint256,uint256)](contracts/security.sol#L4119-L4198) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/security.sol#L4165)
	- [inverse = (3 * denominator) ^ 2](contracts/security.sol#L4180)

contracts/security.sol#L4119-L4198


 - [ ] ID-7
[Math.mulDiv(uint256,uint256,uint256)](contracts/security.sol#L4119-L4198) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/security.sol#L4165)
	- [inverse *= 2 - denominator * inverse](contracts/security.sol#L4184)

contracts/security.sol#L4119-L4198


 - [ ] ID-8
[Math.mulDiv(uint256,uint256,uint256)](contracts/security.sol#L4119-L4198) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/security.sol#L4165)
	- [inverse *= 2 - denominator * inverse](contracts/security.sol#L4187)

contracts/security.sol#L4119-L4198


 - [ ] ID-9
[Math.mulDiv(uint256,uint256,uint256)](contracts/security.sol#L4119-L4198) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/security.sol#L4165)
	- [inverse *= 2 - denominator * inverse](contracts/security.sol#L4188)

contracts/security.sol#L4119-L4198


 - [ ] ID-10
[Math.mulDiv(uint256,uint256,uint256)](contracts/security.sol#L4119-L4198) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/security.sol#L4165)
	- [inverse *= 2 - denominator * inverse](contracts/security.sol#L4185)

contracts/security.sol#L4119-L4198


## unused-return
Impact: Medium
Confidence: Medium
 - [ ] ID-11
[ERC1967Utils.upgradeToAndCall(address,bytes)](contracts/security.sol#L1095-L1104) ignores return value by [Address.functionDelegateCall(newImplementation,data)](contracts/security.sol#L1100)

contracts/security.sol#L1095-L1104


 - [ ] ID-12
[ERC1967Utils.upgradeBeaconToAndCall(address,bytes)](contracts/security.sol#L1185-L1194) ignores return value by [Address.functionDelegateCall(IBeacon(newBeacon).implementation(),data)](contracts/security.sol#L1190)

contracts/security.sol#L1185-L1194


## return-bomb
Impact: Low
Confidence: Medium
 - [ ] ID-13
[MinimalForwarder.execute(MinimalForwarder.ForwardRequest,bytes)](contracts/security.sol#L5204-L5228) tries to limit the gas of an external call that controls implicit decoding
	[(success,returndata) = req.to.call{gas: req.gas,value: req.value}(abi.encodePacked(req.data,req.from))](contracts/security.sol#L5211-L5213)

contracts/security.sol#L5204-L5228


## timestamp
Impact: Low
Confidence: Medium
 - [ ] ID-14
[Security.attachDocument(bytes32,string,bytes32)](contracts/security.sol#L5358-L5367) uses timestamp for comparisons
	Dangerous comparisons:
	- [require(bool,string)(documents[_name].timeStamp == 0,Name already exists)](contracts/security.sol#L5362)

contracts/security.sol#L5358-L5367


## assembly
Impact: Informational
Confidence: High
 - [ ] ID-15
[Initializable._getInitializableStorage()](contracts/security.sol#L221-L225) uses assembly
	- [INLINE ASM](contracts/security.sol#L222-L224)

contracts/security.sol#L221-L225


 - [ ] ID-16
[ERC20Upgradeable._getERC20Storage()](contracts/security.sol#L1689-L1693) uses assembly
	- [INLINE ASM](contracts/security.sol#L1690-L1692)

contracts/security.sol#L1689-L1693


 - [ ] ID-17
[Math.tryModExp(bytes,bytes,bytes)](contracts/security.sol#L4338-L4361) uses assembly
	- [INLINE ASM](contracts/security.sol#L4351-L4360)

contracts/security.sol#L4338-L4361


 - [ ] ID-18
[StorageSlot.getStringSlot(bytes32)](contracts/security.sol#L974-L979) uses assembly
	- [INLINE ASM](contracts/security.sol#L976-L978)

contracts/security.sol#L974-L979


 - [ ] ID-19
[StorageSlot.getBytesSlot(bytes)](contracts/security.sol#L1004-L1009) uses assembly
	- [INLINE ASM](contracts/security.sol#L1006-L1008)

contracts/security.sol#L1004-L1009


 - [ ] ID-20
[Address._revert(bytes)](contracts/security.sol#L858-L870) uses assembly
	- [INLINE ASM](contracts/security.sol#L863-L866)

contracts/security.sol#L858-L870


 - [ ] ID-21
[StorageSlot.getAddressSlot(bytes32)](contracts/security.sol#L934-L939) uses assembly
	- [INLINE ASM](contracts/security.sol#L936-L938)

contracts/security.sol#L934-L939


 - [ ] ID-22
[ECDSA.tryRecover(bytes32,bytes)](contracts/security.sol#L2615-L2632) uses assembly
	- [INLINE ASM](contracts/security.sol#L2623-L2627)

contracts/security.sol#L2615-L2632


 - [ ] ID-23
[Math.tryModExp(uint256,uint256,uint256)](contracts/security.sol#L4297-L4322) uses assembly
	- [INLINE ASM](contracts/security.sol#L4300-L4321)

contracts/security.sol#L4297-L4322


 - [ ] ID-24
[StorageSlot.getBooleanSlot(bytes32)](contracts/security.sol#L944-L949) uses assembly
	- [INLINE ASM](contracts/security.sol#L946-L948)

contracts/security.sol#L944-L949


 - [ ] ID-25
[Security.stringToBytes32(string)](contracts/security.sol#L5287-L5293) uses assembly
	- [INLINE ASM](contracts/security.sol#L5289-L5291)

contracts/security.sol#L5287-L5293


 - [ ] ID-26
[MessageHashUtils.toEthSignedMessageHash(bytes32)](contracts/security.sol#L4826-L4833) uses assembly
	- [INLINE ASM](contracts/security.sol#L4828-L4832)

contracts/security.sol#L4826-L4833


 - [ ] ID-27
[StorageSlot.getBytesSlot(bytes32)](contracts/security.sol#L994-L999) uses assembly
	- [INLINE ASM](contracts/security.sol#L996-L998)

contracts/security.sol#L994-L999


 - [ ] ID-28
[Strings.toString(uint256)](contracts/security.sol#L4725-L4745) uses assembly
	- [INLINE ASM](contracts/security.sol#L4731-L4733)
	- [INLINE ASM](contracts/security.sol#L4737-L4739)

contracts/security.sol#L4725-L4745


 - [ ] ID-29
[SafeCast.toUint(bool)](contracts/security.sol#L3926-L3931) uses assembly
	- [INLINE ASM](contracts/security.sol#L3928-L3930)

contracts/security.sol#L3926-L3931


 - [ ] ID-30
[MinimalForwarder.execute(MinimalForwarder.ForwardRequest,bytes)](contracts/security.sol#L5204-L5228) uses assembly
	- [INLINE ASM](contracts/security.sol#L5222-L5224)

contracts/security.sol#L5204-L5228


 - [ ] ID-31
[ShortStrings.toString(ShortString)](contracts/security.sol#L4938-L4948) uses assembly
	- [INLINE ASM](contracts/security.sol#L4943-L4946)

contracts/security.sol#L4938-L4948


 - [ ] ID-32
[AccessControlUpgradeable._getAccessControlStorage()](contracts/security.sol#L498-L502) uses assembly
	- [INLINE ASM](contracts/security.sol#L499-L501)

contracts/security.sol#L498-L502


 - [ ] ID-33
[StorageSlot.getStringSlot(string)](contracts/security.sol#L984-L989) uses assembly
	- [INLINE ASM](contracts/security.sol#L986-L988)

contracts/security.sol#L984-L989


 - [ ] ID-34
[Panic.panic(uint256)](contracts/security.sol#L3983-L3990) uses assembly
	- [INLINE ASM](contracts/security.sol#L3985-L3989)

contracts/security.sol#L3983-L3990


 - [ ] ID-35
[StorageSlot.getBytes32Slot(bytes32)](contracts/security.sol#L954-L959) uses assembly
	- [INLINE ASM](contracts/security.sol#L956-L958)

contracts/security.sol#L954-L959


 - [ ] ID-36
[StorageSlot.getUint256Slot(bytes32)](contracts/security.sol#L964-L969) uses assembly
	- [INLINE ASM](contracts/security.sol#L966-L968)

contracts/security.sol#L964-L969


 - [ ] ID-37
[MessageHashUtils.toTypedDataHash(bytes32,bytes32)](contracts/security.sol#L4872-L4881) uses assembly
	- [INLINE ASM](contracts/security.sol#L4874-L4880)

contracts/security.sol#L4872-L4881


 - [ ] ID-38
[Math.mulDiv(uint256,uint256,uint256)](contracts/security.sol#L4119-L4198) uses assembly
	- [INLINE ASM](contracts/security.sol#L4126-L4129)
	- [INLINE ASM](contracts/security.sol#L4150-L4157)
	- [INLINE ASM](contracts/security.sol#L4163-L4172)

contracts/security.sol#L4119-L4198


 - [ ] ID-39
[Security._msgSender()](contracts/security.sol#L5300-L5310) uses assembly
	- [INLINE ASM](contracts/security.sol#L5304-L5306)

contracts/security.sol#L5300-L5310


 - [ ] ID-40
[PausableUpgradeable._getPausableStorage()](contracts/security.sol#L2008-L2012) uses assembly
	- [INLINE ASM](contracts/security.sol#L2009-L2011)

contracts/security.sol#L2008-L2012


## dead-code
Impact: Informational
Confidence: Medium
 - [ ] ID-41
[Math.modExp(bytes,bytes,bytes)](contracts/security.sol#L4327-L4333) is never used and should be removed

contracts/security.sol#L4327-L4333


 - [ ] ID-42
[ERC20PausableUpgradeable.__ERC20Pausable_init_unchained()](contracts/security.sol#L2151-L2152) is never used and should be removed

contracts/security.sol#L2151-L2152


 - [ ] ID-43
[ContextUpgradeable._msgData()](contracts/security.sol#L256-L258) is never used and should be removed

contracts/security.sol#L256-L258


 - [ ] ID-44
[Strings.toHexString(uint256,uint256)](contracts/security.sol#L4766-L4779) is never used and should be removed

contracts/security.sol#L4766-L4779


 - [ ] ID-45
[SafeCast.toUint216(uint256)](contracts/security.sol#L2887-L2892) is never used and should be removed

contracts/security.sol#L2887-L2892


 - [ ] ID-46
[SafeCast.toUint248(uint256)](contracts/security.sol#L2819-L2824) is never used and should be removed

contracts/security.sol#L2819-L2824


 - [ ] ID-47
[SafeCast.toUint80(uint256)](contracts/security.sol#L3176-L3181) is never used and should be removed

contracts/security.sol#L3176-L3181


 - [ ] ID-48
[ERC1967Utils._setAdmin(address)](contracts/security.sol#L1127-L1132) is never used and should be removed

contracts/security.sol#L1127-L1132


 - [ ] ID-49
[SafeCast.toUint240(uint256)](contracts/security.sol#L2836-L2841) is never used and should be removed

contracts/security.sol#L2836-L2841


 - [ ] ID-50
[StorageSlot.getBytesSlot(bytes)](contracts/security.sol#L1004-L1009) is never used and should be removed

contracts/security.sol#L1004-L1009


 - [ ] ID-51
[Address.sendValue(address,uint256)](contracts/security.sol#L753-L762) is never used and should be removed

contracts/security.sol#L753-L762


 - [ ] ID-52
[Math.ceilDiv(uint256,uint256)](contracts/security.sol#L4096-L4110) is never used and should be removed

contracts/security.sol#L4096-L4110


 - [ ] ID-53
[SafeCast.toInt96(int256)](contracts/security.sol#L3703-L3708) is never used and should be removed

contracts/security.sol#L3703-L3708


 - [ ] ID-54
[Address.functionCallWithValue(address,bytes,uint256)](contracts/security.sol#L795-L801) is never used and should be removed

contracts/security.sol#L795-L801


 - [ ] ID-55
[ContextUpgradeable._contextSuffixLength()](contracts/security.sol#L260-L262) is never used and should be removed

contracts/security.sol#L260-L262


 - [ ] ID-56
[StorageSlot.getUint256Slot(bytes32)](contracts/security.sol#L964-L969) is never used and should be removed

contracts/security.sol#L964-L969


 - [ ] ID-57
[SignedMath.min(int256,int256)](contracts/security.sol#L4671-L4673) is never used and should be removed

contracts/security.sol#L4671-L4673


 - [ ] ID-58
[ERC1967Utils.upgradeBeaconToAndCall(address,bytes)](contracts/security.sol#L1185-L1194) is never used and should be removed

contracts/security.sol#L1185-L1194


 - [ ] ID-59
[SafeCast.toInt104(int256)](contracts/security.sol#L3685-L3690) is never used and should be removed

contracts/security.sol#L3685-L3690


 - [ ] ID-60
[MessageHashUtils.toDataWithIntendedValidatorHash(address,bytes)](contracts/security.sol#L4859-L4861) is never used and should be removed

contracts/security.sol#L4859-L4861


 - [ ] ID-61
[SafeCast.toUint112(uint256)](contracts/security.sol#L3108-L3113) is never used and should be removed

contracts/security.sol#L3108-L3113


 - [ ] ID-62
[StorageSlot.getStringSlot(bytes32)](contracts/security.sol#L974-L979) is never used and should be removed

contracts/security.sol#L974-L979


 - [ ] ID-63
[Math.log10(uint256,Math.Rounding)](contracts/security.sol#L4592-L4597) is never used and should be removed

contracts/security.sol#L4592-L4597


 - [ ] ID-64
[SafeCast.toUint208(uint256)](contracts/security.sol#L2904-L2909) is never used and should be removed

contracts/security.sol#L2904-L2909


 - [ ] ID-65
[SafeCast.toInt24(int256)](contracts/security.sol#L3865-L3870) is never used and should be removed

contracts/security.sol#L3865-L3870


 - [ ] ID-66
[SafeCast.toUint64(uint256)](contracts/security.sol#L3210-L3215) is never used and should be removed

contracts/security.sol#L3210-L3215


 - [ ] ID-67
[SafeCast.toUint168(uint256)](contracts/security.sol#L2989-L2994) is never used and should be removed

contracts/security.sol#L2989-L2994


 - [ ] ID-68
[SafeCast.toUint256(int256)](contracts/security.sol#L3343-L3348) is never used and should be removed

contracts/security.sol#L3343-L3348


 - [ ] ID-69
[SafeCast.toInt216(int256)](contracts/security.sol#L3433-L3438) is never used and should be removed

contracts/security.sol#L3433-L3438


 - [ ] ID-70
[ERC1967Utils.getAdmin()](contracts/security.sol#L1120-L1122) is never used and should be removed

contracts/security.sol#L1120-L1122


 - [ ] ID-71
[SafeCast.toInt248(int256)](contracts/security.sol#L3361-L3366) is never used and should be removed

contracts/security.sol#L3361-L3366


 - [ ] ID-72
[Math.mulDiv(uint256,uint256,uint256)](contracts/security.sol#L4119-L4198) is never used and should be removed

contracts/security.sol#L4119-L4198


 - [ ] ID-73
[SafeCast.toInt256(uint256)](contracts/security.sol#L3915-L3921) is never used and should be removed

contracts/security.sol#L3915-L3921


 - [ ] ID-74
[SafeCast.toInt160(int256)](contracts/security.sol#L3559-L3564) is never used and should be removed

contracts/security.sol#L3559-L3564


 - [ ] ID-75
[Math.tryDiv(uint256,uint256)](contracts/security.sol#L4050-L4055) is never used and should be removed

contracts/security.sol#L4050-L4055


 - [ ] ID-76
[SignedMath.average(int256,int256)](contracts/security.sol#L4679-L4683) is never used and should be removed

contracts/security.sol#L4679-L4683


 - [ ] ID-77
[SafeCast.toUint144(uint256)](contracts/security.sol#L3040-L3045) is never used and should be removed

contracts/security.sol#L3040-L3045


 - [ ] ID-78
[Strings.toHexString(uint256)](contracts/security.sol#L4757-L4761) is never used and should be removed

contracts/security.sol#L4757-L4761


 - [ ] ID-79
[Math._zeroBytes(bytes)](contracts/security.sol#L4366-L4373) is never used and should be removed

contracts/security.sol#L4366-L4373


 - [ ] ID-80
[SafeCast.toInt120(int256)](contracts/security.sol#L3649-L3654) is never used and should be removed

contracts/security.sol#L3649-L3654


 - [ ] ID-81
[SafeCast.toInt184(int256)](contracts/security.sol#L3505-L3510) is never used and should be removed

contracts/security.sol#L3505-L3510


 - [ ] ID-82
[Math.sqrt(uint256,Math.Rounding)](contracts/security.sol#L4491-L4496) is never used and should be removed

contracts/security.sol#L4491-L4496


 - [ ] ID-83
[ContextUpgradeable.__Context_init_unchained()](contracts/security.sol#L250-L251) is never used and should be removed

contracts/security.sol#L250-L251


 - [ ] ID-84
[Math.max(uint256,uint256)](contracts/security.sol#L4070-L4072) is never used and should be removed

contracts/security.sol#L4070-L4072


 - [ ] ID-85
[SafeCast.toUint128(uint256)](contracts/security.sol#L3074-L3079) is never used and should be removed

contracts/security.sol#L3074-L3079


 - [ ] ID-86
[SafeCast.toInt80(int256)](contracts/security.sol#L3739-L3744) is never used and should be removed

contracts/security.sol#L3739-L3744


 - [ ] ID-87
[SafeCast.toInt240(int256)](contracts/security.sol#L3379-L3384) is never used and should be removed

contracts/security.sol#L3379-L3384


 - [ ] ID-88
[Math.log2(uint256)](contracts/security.sol#L4502-L4537) is never used and should be removed

contracts/security.sol#L4502-L4537


 - [ ] ID-89
[ERC165Upgradeable.__ERC165_init_unchained()](contracts/security.sol#L319-L320) is never used and should be removed

contracts/security.sol#L319-L320


 - [ ] ID-90
[Math.average(uint256,uint256)](contracts/security.sol#L4085-L4088) is never used and should be removed

contracts/security.sol#L4085-L4088


 - [ ] ID-91
[SafeCast.toInt144(int256)](contracts/security.sol#L3595-L3600) is never used and should be removed

contracts/security.sol#L3595-L3600


 - [ ] ID-92
[SafeCast.toInt200(int256)](contracts/security.sol#L3469-L3474) is never used and should be removed

contracts/security.sol#L3469-L3474


 - [ ] ID-93
[SafeCast.toInt40(int256)](contracts/security.sol#L3829-L3834) is never used and should be removed

contracts/security.sol#L3829-L3834


 - [ ] ID-94
[Math.log2(uint256,Math.Rounding)](contracts/security.sol#L4543-L4548) is never used and should be removed

contracts/security.sol#L4543-L4548


 - [ ] ID-95
[SafeCast.toUint40(uint256)](contracts/security.sol#L3261-L3266) is never used and should be removed

contracts/security.sol#L3261-L3266


 - [ ] ID-96
[SafeCast.toInt224(int256)](contracts/security.sol#L3415-L3420) is never used and should be removed

contracts/security.sol#L3415-L3420


 - [ ] ID-97
[SafeCast.toInt208(int256)](contracts/security.sol#L3451-L3456) is never used and should be removed

contracts/security.sol#L3451-L3456


 - [ ] ID-98
[ERC1967Utils.getBeacon()](contracts/security.sol#L1154-L1156) is never used and should be removed

contracts/security.sol#L1154-L1156


 - [ ] ID-99
[SafeCast.toUint72(uint256)](contracts/security.sol#L3193-L3198) is never used and should be removed

contracts/security.sol#L3193-L3198


 - [ ] ID-100
[SafeCast.toInt88(int256)](contracts/security.sol#L3721-L3726) is never used and should be removed

contracts/security.sol#L3721-L3726


 - [ ] ID-101
[Math.log256(uint256)](contracts/security.sol#L4605-L4628) is never used and should be removed

contracts/security.sol#L4605-L4628


 - [ ] ID-102
[SafeCast.toUint(bool)](contracts/security.sol#L3926-L3931) is never used and should be removed

contracts/security.sol#L3926-L3931


 - [ ] ID-103
[SafeCast.toUint8(uint256)](contracts/security.sol#L3329-L3334) is never used and should be removed

contracts/security.sol#L3329-L3334


 - [ ] ID-104
[PausableUpgradeable.__Pausable_init()](contracts/security.sol#L2037-L2039) is never used and should be removed

contracts/security.sol#L2037-L2039


 - [ ] ID-105
[Strings.toString(uint256)](contracts/security.sol#L4725-L4745) is never used and should be removed

contracts/security.sol#L4725-L4745


 - [ ] ID-106
[SafeCast.toUint24(uint256)](contracts/security.sol#L3295-L3300) is never used and should be removed

contracts/security.sol#L3295-L3300


 - [ ] ID-107
[ERC1967Utils._setBeacon(address)](contracts/security.sol#L1161-L1172) is never used and should be removed

contracts/security.sol#L1161-L1172


 - [ ] ID-108
[Math.tryModExp(uint256,uint256,uint256)](contracts/security.sol#L4297-L4322) is never used and should be removed

contracts/security.sol#L4297-L4322


 - [ ] ID-109
[Math.modExp(uint256,uint256,uint256)](contracts/security.sol#L4279-L4285) is never used and should be removed

contracts/security.sol#L4279-L4285


 - [ ] ID-110
[Math.log256(uint256,Math.Rounding)](contracts/security.sol#L4634-L4639) is never used and should be removed

contracts/security.sol#L4634-L4639


 - [ ] ID-111
[SafeCast.toInt128(int256)](contracts/security.sol#L3631-L3636) is never used and should be removed

contracts/security.sol#L3631-L3636


 - [ ] ID-112
[Math.sqrt(uint256)](contracts/security.sol#L4382-L4486) is never used and should be removed

contracts/security.sol#L4382-L4486


 - [ ] ID-113
[SafeCast.toInt32(int256)](contracts/security.sol#L3847-L3852) is never used and should be removed

contracts/security.sol#L3847-L3852


 - [ ] ID-114
[SafeCast.toInt112(int256)](contracts/security.sol#L3667-L3672) is never used and should be removed

contracts/security.sol#L3667-L3672


 - [ ] ID-115
[AccessControlUpgradeable._setRoleAdmin(bytes32,bytes32)](contracts/security.sol#L622-L627) is never used and should be removed

contracts/security.sol#L622-L627


 - [ ] ID-116
[SafeCast.toUint232(uint256)](contracts/security.sol#L2853-L2858) is never used and should be removed

contracts/security.sol#L2853-L2858


 - [ ] ID-117
[SafeCast.toInt64(int256)](contracts/security.sol#L3775-L3780) is never used and should be removed

contracts/security.sol#L3775-L3780


 - [ ] ID-118
[Security._msgData()](contracts/security.sol#L5312-L5318) is never used and should be removed

contracts/security.sol#L5312-L5318


 - [ ] ID-119
[Math.tryAdd(uint256,uint256)](contracts/security.sol#L4014-L4020) is never used and should be removed

contracts/security.sol#L4014-L4020


 - [ ] ID-120
[Address.functionStaticCall(address,bytes)](contracts/security.sol#L807-L810) is never used and should be removed

contracts/security.sol#L807-L810


 - [ ] ID-121
[SafeCast.toInt56(int256)](contracts/security.sol#L3793-L3798) is never used and should be removed

contracts/security.sol#L3793-L3798


 - [ ] ID-122
[SafeCast.toUint104(uint256)](contracts/security.sol#L3125-L3130) is never used and should be removed

contracts/security.sol#L3125-L3130


 - [ ] ID-123
[SafeCast.toUint152(uint256)](contracts/security.sol#L3023-L3028) is never used and should be removed

contracts/security.sol#L3023-L3028


 - [ ] ID-124
[SafeCast.toInt232(int256)](contracts/security.sol#L3397-L3402) is never used and should be removed

contracts/security.sol#L3397-L3402


 - [ ] ID-125
[SafeCast.toUint224(uint256)](contracts/security.sol#L2870-L2875) is never used and should be removed

contracts/security.sol#L2870-L2875


 - [ ] ID-126
[ERC165Upgradeable.__ERC165_init()](contracts/security.sol#L316-L317) is never used and should be removed

contracts/security.sol#L316-L317


 - [ ] ID-127
[Math.mulDiv(uint256,uint256,uint256,Math.Rounding)](contracts/security.sol#L4203-L4205) is never used and should be removed

contracts/security.sol#L4203-L4205


 - [ ] ID-128
[SafeCast.toInt152(int256)](contracts/security.sol#L3577-L3582) is never used and should be removed

contracts/security.sol#L3577-L3582


 - [ ] ID-129
[SafeCast.toInt176(int256)](contracts/security.sol#L3523-L3528) is never used and should be removed

contracts/security.sol#L3523-L3528


 - [ ] ID-130
[SafeCast.toInt8(int256)](contracts/security.sol#L3901-L3906) is never used and should be removed

contracts/security.sol#L3901-L3906


 - [ ] ID-131
[Math.log10(uint256)](contracts/security.sol#L4554-L4586) is never used and should be removed

contracts/security.sol#L4554-L4586


 - [ ] ID-132
[SafeCast.toInt48(int256)](contracts/security.sol#L3811-L3816) is never used and should be removed

contracts/security.sol#L3811-L3816


 - [ ] ID-133
[SafeCast.toUint192(uint256)](contracts/security.sol#L2938-L2943) is never used and should be removed

contracts/security.sol#L2938-L2943


 - [ ] ID-134
[SafeCast.toUint200(uint256)](contracts/security.sol#L2921-L2926) is never used and should be removed

contracts/security.sol#L2921-L2926


 - [ ] ID-135
[SafeCast.toUint96(uint256)](contracts/security.sol#L3142-L3147) is never used and should be removed

contracts/security.sol#L3142-L3147


 - [ ] ID-136
[Math.tryModExp(bytes,bytes,bytes)](contracts/security.sol#L4338-L4361) is never used and should be removed

contracts/security.sol#L4338-L4361


 - [ ] ID-137
[ECDSA.tryRecover(bytes32,bytes32,bytes32)](contracts/security.sol#L2659-L2666) is never used and should be removed

contracts/security.sol#L2659-L2666


 - [ ] ID-138
[ShortStrings.byteLengthWithFallback(ShortString,string)](contracts/security.sol#L4991-L4997) is never used and should be removed

contracts/security.sol#L4991-L4997


 - [ ] ID-139
[MessageHashUtils.toEthSignedMessageHash(bytes)](contracts/security.sol#L4845-L4848) is never used and should be removed

contracts/security.sol#L4845-L4848


 - [ ] ID-140
[SafeCast.toUint184(uint256)](contracts/security.sol#L2955-L2960) is never used and should be removed

contracts/security.sol#L2955-L2960


 - [ ] ID-141
[UUPSUpgradeable.__UUPSUpgradeable_init_unchained()](contracts/security.sol#L1275-L1276) is never used and should be removed

contracts/security.sol#L1275-L1276


 - [ ] ID-142
[ERC1967Utils.changeAdmin(address)](contracts/security.sol#L1139-L1142) is never used and should be removed

contracts/security.sol#L1139-L1142


 - [ ] ID-143
[SafeCast.toUint160(uint256)](contracts/security.sol#L3006-L3011) is never used and should be removed

contracts/security.sol#L3006-L3011


 - [ ] ID-144
[Strings.toHexString(address)](contracts/security.sol#L4785-L4787) is never used and should be removed

contracts/security.sol#L4785-L4787


 - [ ] ID-145
[AccessControlUpgradeable.__AccessControl_init_unchained()](contracts/security.sol#L516-L517) is never used and should be removed

contracts/security.sol#L516-L517


 - [ ] ID-146
[SafeCast.toUint16(uint256)](contracts/security.sol#L3312-L3317) is never used and should be removed

contracts/security.sol#L3312-L3317


 - [ ] ID-147
[SafeCast.toInt16(int256)](contracts/security.sol#L3883-L3888) is never used and should be removed

contracts/security.sol#L3883-L3888


 - [ ] ID-148
[Initializable._getInitializedVersion()](contracts/security.sol#L206-L208) is never used and should be removed

contracts/security.sol#L206-L208


 - [ ] ID-149
[SafeCast.toInt168(int256)](contracts/security.sol#L3541-L3546) is never used and should be removed

contracts/security.sol#L3541-L3546


 - [ ] ID-150
[Strings.toStringSigned(int256)](contracts/security.sol#L4750-L4752) is never used and should be removed

contracts/security.sol#L4750-L4752


 - [ ] ID-151
[SafeCast.toUint176(uint256)](contracts/security.sol#L2972-L2977) is never used and should be removed

contracts/security.sol#L2972-L2977


 - [ ] ID-152
[SafeCast.toUint48(uint256)](contracts/security.sol#L3244-L3249) is never used and should be removed

contracts/security.sol#L3244-L3249


 - [ ] ID-153
[Math.invMod(uint256,uint256)](contracts/security.sol#L4218-L4264) is never used and should be removed

contracts/security.sol#L4218-L4264


 - [ ] ID-154
[Math.trySub(uint256,uint256)](contracts/security.sol#L4025-L4030) is never used and should be removed

contracts/security.sol#L4025-L4030


 - [ ] ID-155
[StorageSlot.getBooleanSlot(bytes32)](contracts/security.sol#L944-L949) is never used and should be removed

contracts/security.sol#L944-L949


 - [ ] ID-156
[Math.tryMul(uint256,uint256)](contracts/security.sol#L4035-L4045) is never used and should be removed

contracts/security.sol#L4035-L4045


 - [ ] ID-157
[StorageSlot.getBytes32Slot(bytes32)](contracts/security.sol#L954-L959) is never used and should be removed

contracts/security.sol#L954-L959


 - [ ] ID-158
[MessageHashUtils.toEthSignedMessageHash(bytes32)](contracts/security.sol#L4826-L4833) is never used and should be removed

contracts/security.sol#L4826-L4833


 - [ ] ID-159
[Strings.equal(string,string)](contracts/security.sol#L4792-L4794) is never used and should be removed

contracts/security.sol#L4792-L4794


 - [ ] ID-160
[SafeCast.toUint56(uint256)](contracts/security.sol#L3227-L3232) is never used and should be removed

contracts/security.sol#L3227-L3232


 - [ ] ID-161
[SafeCast.toUint88(uint256)](contracts/security.sol#L3159-L3164) is never used and should be removed

contracts/security.sol#L3159-L3164


 - [ ] ID-162
[Math.tryMod(uint256,uint256)](contracts/security.sol#L4060-L4065) is never used and should be removed

contracts/security.sol#L4060-L4065


 - [ ] ID-163
[Math.min(uint256,uint256)](contracts/security.sol#L4077-L4079) is never used and should be removed

contracts/security.sol#L4077-L4079


 - [ ] ID-164
[ECDSA.recover(bytes32,uint8,bytes32,bytes32)](contracts/security.sol#L2713-L2717) is never used and should be removed

contracts/security.sol#L2713-L2717


 - [ ] ID-165
[Address.verifyCallResult(bool,bytes)](contracts/security.sol#L847-L853) is never used and should be removed

contracts/security.sol#L847-L853


 - [ ] ID-166
[SafeCast.toInt72(int256)](contracts/security.sol#L3757-L3762) is never used and should be removed

contracts/security.sol#L3757-L3762


 - [ ] ID-167
[SignedMath.max(int256,int256)](contracts/security.sol#L4664-L4666) is never used and should be removed

contracts/security.sol#L4664-L4666


 - [ ] ID-168
[SignedMath.abs(int256)](contracts/security.sol#L4688-L4700) is never used and should be removed

contracts/security.sol#L4688-L4700


 - [ ] ID-169
[ECDSA.recover(bytes32,bytes32,bytes32)](contracts/security.sol#L2671-L2675) is never used and should be removed

contracts/security.sol#L2671-L2675


 - [ ] ID-170
[SafeCast.toUint32(uint256)](contracts/security.sol#L3278-L3283) is never used and should be removed

contracts/security.sol#L3278-L3283


 - [ ] ID-171
[SafeCast.toUint120(uint256)](contracts/security.sol#L3091-L3096) is never used and should be removed

contracts/security.sol#L3091-L3096


 - [ ] ID-172
[Math.unsignedRoundsUp(Math.Rounding)](contracts/security.sol#L4644-L4646) is never used and should be removed

contracts/security.sol#L4644-L4646


 - [ ] ID-173
[Panic.panic(uint256)](contracts/security.sol#L3983-L3990) is never used and should be removed

contracts/security.sol#L3983-L3990


 - [ ] ID-174
[ContextUpgradeable.__Context_init()](contracts/security.sol#L247-L248) is never used and should be removed

contracts/security.sol#L247-L248


 - [ ] ID-175
[SafeCast.toUint136(uint256)](contracts/security.sol#L3057-L3062) is never used and should be removed

contracts/security.sol#L3057-L3062


 - [ ] ID-176
[StorageSlot.getBytesSlot(bytes32)](contracts/security.sol#L994-L999) is never used and should be removed

contracts/security.sol#L994-L999


 - [ ] ID-177
[SafeCast.toInt136(int256)](contracts/security.sol#L3613-L3618) is never used and should be removed

contracts/security.sol#L3613-L3618


 - [ ] ID-178
[Address.functionCall(address,bytes)](contracts/security.sol#L782-L784) is never used and should be removed

contracts/security.sol#L782-L784


 - [ ] ID-179
[SafeCast.toInt192(int256)](contracts/security.sol#L3487-L3492) is never used and should be removed

contracts/security.sol#L3487-L3492


## solc-version
Impact: Informational
Confidence: High
 - [ ] ID-180
Version constraint ^0.8.20 contains known severe issues (https://solidity.readthedocs.io/en/latest/bugs.html)
	- VerbatimInvalidDeduplication
	- FullInlinerNonExpressionSplitArgumentEvaluationOrder
	- MissingSideEffectsOnSelectorAccess.
 It is used by:
	- contracts/security.sol#2

## low-level-calls
Impact: Informational
Confidence: High
 - [ ] ID-181
Low level call in [MinimalForwarder.execute(MinimalForwarder.ForwardRequest,bytes)](contracts/security.sol#L5204-L5228):
	- [(success,returndata) = req.to.call{gas: req.gas,value: req.value}(abi.encodePacked(req.data,req.from))](contracts/security.sol#L5211-L5213)

contracts/security.sol#L5204-L5228


 - [ ] ID-182
Low level call in [Address.functionDelegateCall(address,bytes)](contracts/security.sol#L816-L819):
	- [(success,returndata) = target.delegatecall(data)](contracts/security.sol#L817)

contracts/security.sol#L816-L819


 - [ ] ID-183
Low level call in [Address.functionStaticCall(address,bytes)](contracts/security.sol#L807-L810):
	- [(success,returndata) = target.staticcall(data)](contracts/security.sol#L808)

contracts/security.sol#L807-L810


 - [ ] ID-184
Low level call in [Address.sendValue(address,uint256)](contracts/security.sol#L753-L762):
	- [(success,None) = recipient.call{value: amount}()](contracts/security.sol#L758)

contracts/security.sol#L753-L762


 - [ ] ID-185
Low level call in [Address.functionCallWithValue(address,bytes,uint256)](contracts/security.sol#L795-L801):
	- [(success,returndata) = target.call{value: value}(data)](contracts/security.sol#L799)

contracts/security.sol#L795-L801


## naming-convention
Impact: Informational
Confidence: High
 - [ ] ID-186
Parameter [Security.transfer(address,uint256)._value](contracts/security.sol#L5375) is not in mixedCase

contracts/security.sol#L5375


 - [ ] ID-187
Constant [AccessControlUpgradeable.AccessControlStorageLocation](contracts/security.sol#L496) is not in UPPER_CASE_WITH_UNDERSCORES

contracts/security.sol#L496


 - [ ] ID-188
Parameter [Security.attachDocument(bytes32,string,bytes32)._uri](contracts/security.sol#L5358) is not in mixedCase

contracts/security.sol#L5358


 - [ ] ID-189
Parameter [Security.stringToBytes32(string)._string](contracts/security.sol#L5287) is not in mixedCase

contracts/security.sol#L5287


 - [ ] ID-190
Function [AccessControlUpgradeable.__AccessControl_init_unchained()](contracts/security.sol#L516-L517) is not in mixedCase

contracts/security.sol#L516-L517


 - [ ] ID-191
Parameter [Security.transferFrom(address,address,uint256)._to](contracts/security.sol#L5384) is not in mixedCase

contracts/security.sol#L5384


 - [ ] ID-192
Parameter [Security.checkTransferAllowed(address,address,uint256)._quantity](contracts/security.sol#L5405) is not in mixedCase

contracts/security.sol#L5405


 - [ ] ID-193
Parameter [Security.initialize(address,address,string,string,uint256,string,string)._contentHash](contracts/security.sol#L5269) is not in mixedCase

contracts/security.sol#L5269


 - [ ] ID-194
Parameter [Utility.setExchange(address)._exchange](contracts/security.sol#L2542) is not in mixedCase

contracts/security.sol#L2542


 - [ ] ID-195
Parameter [UtilityOverride._Utility_initialize(string,string)._symbol](contracts/security.sol#L2507) is not in mixedCase

contracts/security.sol#L2507


 - [ ] ID-196
Parameter [Security.initialize(address,address,string,string,uint256,string,string)._trustedForwarder](contracts/security.sol#L5269) is not in mixedCase

contracts/security.sol#L5269


 - [ ] ID-197
Parameter [Security.whiteListSelf(address,uint256)._person](contracts/security.sol#L5320) is not in mixedCase

contracts/security.sol#L5320


 - [ ] ID-198
Parameter [Security.checkTransferAllowed(address,address,uint256)._to](contracts/security.sol#L5405) is not in mixedCase

contracts/security.sol#L5405


 - [ ] ID-199
Parameter [Security.transfer(address,uint256)._to](contracts/security.sol#L5375) is not in mixedCase

contracts/security.sol#L5375


 - [ ] ID-200
Function [EIP712._EIP712Version()](contracts/security.sol#L5154-L5156) is not in mixedCase

contracts/security.sol#L5154-L5156


 - [ ] ID-201
Parameter [Security.whiteListOne(address,uint256)._amount](contracts/security.sol#L5330) is not in mixedCase

contracts/security.sol#L5330


 - [ ] ID-202
Function [UtilityOverride._Utility_initialize(string,string)](contracts/security.sol#L2507-L2517) is not in mixedCase

contracts/security.sol#L2507-L2517


 - [ ] ID-203
Function [ERC20Upgradeable.__ERC20_init_unchained(string,string)](contracts/security.sol#L1705-L1709) is not in mixedCase

contracts/security.sol#L1705-L1709


 - [ ] ID-204
Parameter [Security.approve(address,uint256)._spender](contracts/security.sol#L5380) is not in mixedCase

contracts/security.sol#L5380


 - [ ] ID-205
Parameter [Security.mint(address,uint256)._amount](contracts/security.sol#L5395) is not in mixedCase

contracts/security.sol#L5395


 - [ ] ID-206
Parameter [Security.transferFrom(address,address,uint256)._from](contracts/security.sol#L5384) is not in mixedCase

contracts/security.sol#L5384


 - [ ] ID-207
Parameter [Security.whiteListSelf(address,uint256)._amount](contracts/security.sol#L5320) is not in mixedCase

contracts/security.sol#L5320


 - [ ] ID-208
Function [ERC20Upgradeable.__ERC20_init(string,string)](contracts/security.sol#L1701-L1703) is not in mixedCase

contracts/security.sol#L1701-L1703


 - [ ] ID-209
Function [ERC165Upgradeable.__ERC165_init_unchained()](contracts/security.sol#L319-L320) is not in mixedCase

contracts/security.sol#L319-L320


 - [ ] ID-210
Function [ContextUpgradeable.__Context_init_unchained()](contracts/security.sol#L250-L251) is not in mixedCase

contracts/security.sol#L250-L251


 - [ ] ID-211
Parameter [Security.checkTransferFromAllowed(address,address,uint256)._to](contracts/security.sol#L5421) is not in mixedCase

contracts/security.sol#L5421


 - [ ] ID-212
Function [UUPSUpgradeable.__UUPSUpgradeable_init_unchained()](contracts/security.sol#L1275-L1276) is not in mixedCase

contracts/security.sol#L1275-L1276


 - [ ] ID-213
Parameter [Security.whiteListOne(address,uint256)._person](contracts/security.sol#L5330) is not in mixedCase

contracts/security.sol#L5330


 - [ ] ID-214
Parameter [Security.checkTransferFromAllowed(address,address,uint256)._quantity](contracts/security.sol#L5421) is not in mixedCase

contracts/security.sol#L5421


 - [ ] ID-215
Parameter [Security.transferFrom(address,address,uint256)._value](contracts/security.sol#L5384) is not in mixedCase

contracts/security.sol#L5384


 - [ ] ID-216
Function [ERC20PausableUpgradeable.__ERC20Pausable_init_unchained()](contracts/security.sol#L2151-L2152) is not in mixedCase

contracts/security.sol#L2151-L2152


 - [ ] ID-217
Function [AccessControlUpgradeable.__AccessControl_init()](contracts/security.sol#L513-L514) is not in mixedCase

contracts/security.sol#L513-L514


 - [ ] ID-218
Parameter [Security.initialize(address,address,string,string,uint256,string,string)._supply](contracts/security.sol#L5269) is not in mixedCase

contracts/security.sol#L5269


 - [ ] ID-219
Parameter [Security.initialize(address,address,string,string,uint256,string,string)._IPFS](contracts/security.sol#L5269) is not in mixedCase

contracts/security.sol#L5269


 - [ ] ID-220
Parameter [Security.initialize(address,address,string,string,uint256,string,string)._name](contracts/security.sol#L5269) is not in mixedCase

contracts/security.sol#L5269


 - [ ] ID-221
Function [ERC20PausableUpgradeable.__ERC20Pausable_init()](contracts/security.sol#L2147-L2149) is not in mixedCase

contracts/security.sol#L2147-L2149


 - [ ] ID-222
Variable [UUPSUpgradeable.__self](contracts/security.sol#L1229) is not in mixedCase

contracts/security.sol#L1229


 - [ ] ID-223
Parameter [Security.whiteListBach(address[],uint256)._people](contracts/security.sol#L5338) is not in mixedCase

contracts/security.sol#L5338


 - [ ] ID-224
Parameter [Security.burn(address,uint256)._account](contracts/security.sol#L5400) is not in mixedCase

contracts/security.sol#L5400


 - [ ] ID-225
Parameter [Security.checkMintAllowed(address,uint256)._to](contracts/security.sol#L5436) is not in mixedCase

contracts/security.sol#L5436


 - [ ] ID-226
Constant [ERC20Upgradeable.ERC20StorageLocation](contracts/security.sol#L1687) is not in UPPER_CASE_WITH_UNDERSCORES

contracts/security.sol#L1687


 - [ ] ID-227
Function [UUPSUpgradeable.__UUPSUpgradeable_init()](contracts/security.sol#L1272-L1273) is not in mixedCase

contracts/security.sol#L1272-L1273


 - [ ] ID-228
Parameter [Security.approve(address,uint256)._amount](contracts/security.sol#L5380) is not in mixedCase

contracts/security.sol#L5380


 - [ ] ID-229
Parameter [Security.mint(address,uint256)._to](contracts/security.sol#L5395) is not in mixedCase

contracts/security.sol#L5395


 - [ ] ID-230
Parameter [Security.initialize(address,address,string,string,uint256,string,string)._symbol](contracts/security.sol#L5269) is not in mixedCase

contracts/security.sol#L5269


 - [ ] ID-231
Parameter [Security.whiteListBach(address[],uint256)._amount](contracts/security.sol#L5338) is not in mixedCase

contracts/security.sol#L5338


 - [ ] ID-232
Parameter [Security.initialize(address,address,string,string,uint256,string,string)._exchange](contracts/security.sol#L5269) is not in mixedCase

contracts/security.sol#L5269


 - [ ] ID-233
Function [EIP712._EIP712Name()](contracts/security.sol#L5143-L5145) is not in mixedCase

contracts/security.sol#L5143-L5145


 - [ ] ID-234
Function [PausableUpgradeable.__Pausable_init()](contracts/security.sol#L2037-L2039) is not in mixedCase

contracts/security.sol#L2037-L2039


 - [ ] ID-235
Parameter [Security.lookupDocument(bytes32)._name](contracts/security.sol#L5369) is not in mixedCase

contracts/security.sol#L5369


 - [ ] ID-236
Parameter [UtilityOverride._Utility_initialize(string,string)._name](contracts/security.sol#L2507) is not in mixedCase

contracts/security.sol#L2507


 - [ ] ID-237
Parameter [Security.checkMintAllowed(address,uint256)._quantity](contracts/security.sol#L5436) is not in mixedCase

contracts/security.sol#L5436


 - [ ] ID-238
Parameter [Security.attachDocument(bytes32,string,bytes32)._contentHash](contracts/security.sol#L5358) is not in mixedCase

contracts/security.sol#L5358


 - [ ] ID-239
Function [ContextUpgradeable.__Context_init()](contracts/security.sol#L247-L248) is not in mixedCase

contracts/security.sol#L247-L248


 - [ ] ID-240
Function [ERC165Upgradeable.__ERC165_init()](contracts/security.sol#L316-L317) is not in mixedCase

contracts/security.sol#L316-L317


 - [ ] ID-241
Parameter [Security.attachDocument(bytes32,string,bytes32)._name](contracts/security.sol#L5358) is not in mixedCase

contracts/security.sol#L5358


 - [ ] ID-242
Parameter [Security.burn(address,uint256)._amount](contracts/security.sol#L5400) is not in mixedCase

contracts/security.sol#L5400


 - [ ] ID-243
Constant [PausableUpgradeable.PausableStorageLocation](contracts/security.sol#L2006) is not in UPPER_CASE_WITH_UNDERSCORES

contracts/security.sol#L2006


 - [ ] ID-244
Function [PausableUpgradeable.__Pausable_init_unchained()](contracts/security.sol#L2041-L2044) is not in mixedCase

contracts/security.sol#L2041-L2044


## too-many-digits
Impact: Informational
Confidence: Medium
 - [ ] ID-245
[ShortStrings.slitherConstructorConstantVariables()](contracts/security.sol#L4915-L4998) uses literals with too many digits:
	- [FALLBACK_SENTINEL = 0x00000000000000000000000000000000000000000000000000000000000000FF](contracts/security.sol#L4917)

contracts/security.sol#L4915-L4998


## unused-state
Impact: Informational
Confidence: High
 - [ ] ID-246
[Panic.GENERIC](contracts/security.sol#L3961) is never used in [Panic](contracts/security.sol#L3959-L3991)

contracts/security.sol#L3961


 - [ ] ID-247
[Panic.ENUM_CONVERSION_ERROR](contracts/security.sol#L3969) is never used in [Panic](contracts/security.sol#L3959-L3991)

contracts/security.sol#L3969


 - [ ] ID-248
[ERC1066.STATUS_INSUFICIENTFUNDS](contracts/security.sol#L2178) is never used in [Security](contracts/security.sol#L5258-L5452)

contracts/security.sol#L2178


 - [ ] ID-249
[Panic.EMPTY_ARRAY_POP](contracts/security.sol#L3973) is never used in [Panic](contracts/security.sol#L3959-L3991)

contracts/security.sol#L3973


 - [ ] ID-250
[Panic.UNDER_OVERFLOW](contracts/security.sol#L3965) is never used in [Panic](contracts/security.sol#L3959-L3991)

contracts/security.sol#L3965


 - [ ] ID-251
[Panic.INVALID_INTERNAL_FUNCTION](contracts/security.sol#L3979) is never used in [Panic](contracts/security.sol#L3959-L3991)

contracts/security.sol#L3979


 - [ ] ID-252
[Panic.ASSERT](contracts/security.sol#L3963) is never used in [Panic](contracts/security.sol#L3959-L3991)

contracts/security.sol#L3963


 - [ ] ID-253
[Panic.ARRAY_OUT_OF_BOUNDS](contracts/security.sol#L3975) is never used in [Panic](contracts/security.sol#L3959-L3991)

contracts/security.sol#L3975


 - [ ] ID-254
[ERC1066.STATUS_TRANSFERVOLUMEEXCEEDED](contracts/security.sol#L2179) is never used in [Security](contracts/security.sol#L5258-L5452)

contracts/security.sol#L2179


 - [ ] ID-255
[Panic.RESOURCE_ERROR](contracts/security.sol#L3977) is never used in [Panic](contracts/security.sol#L3959-L3991)

contracts/security.sol#L3977


 - [ ] ID-256
[Panic.STORAGE_ENCODING_ERROR](contracts/security.sol#L3971) is never used in [Panic](contracts/security.sol#L3959-L3991)

contracts/security.sol#L3971


 - [ ] ID-257
[Panic.DIVISION_BY_ZERO](contracts/security.sol#L3967) is never used in [Panic](contracts/security.sol#L3959-L3991)

contracts/security.sol#L3967


