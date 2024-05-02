Summary
 - [arbitrary-send-erc20](#arbitrary-send-erc20) (4 results) (High)
 - [arbitrary-send-eth](#arbitrary-send-eth) (1 results) (High)
 - [incorrect-exp](#incorrect-exp) (1 results) (High)
 - [unchecked-transfer](#unchecked-transfer) (7 results) (High)
 - [divide-before-multiply](#divide-before-multiply) (9 results) (Medium)
 - [unused-return](#unused-return) (2 results) (Medium)
 - [return-bomb](#return-bomb) (1 results) (Low)
 - [assembly](#assembly) (23 results) (Informational)
 - [dead-code](#dead-code) (140 results) (Informational)
 - [solc-version](#solc-version) (1 results) (Informational)
 - [low-level-calls](#low-level-calls) (5 results) (Informational)
 - [naming-convention](#naming-convention) (46 results) (Informational)
 - [too-many-digits](#too-many-digits) (1 results) (Informational)
 - [unused-state](#unused-state) (10 results) (Informational)
## arbitrary-send-erc20
Impact: High
Confidence: High
 - [ ] ID-0
[Exchange.comprar(string,string,uint256)](contracts/exchange.sol#L4459-L4484) uses arbitrary from in transferFrom: [currency[_currency].transferFrom(_from,crowdfounding[_security],_amount)](contracts/exchange.sol#L4478)

contracts/exchange.sol#L4459-L4484


 - [ ] ID-1
[Exchange.withdraw(address,address,uint256,string)](contracts/exchange.sol#L4402-L4405) uses arbitrary from in transferFrom: [currency[_tokenName].transferFrom(_from,_to,_amount)](contracts/exchange.sol#L4404)

contracts/exchange.sol#L4402-L4405


 - [ ] ID-2
[Exchange.comprar(string,string,uint256)](contracts/exchange.sol#L4459-L4484) uses arbitrary from in transferFrom: [currency[_currency].transferFrom(_from,crowdfounding[_security],_amount)](contracts/exchange.sol#L4465)

contracts/exchange.sol#L4459-L4484


 - [ ] ID-3
[Exchange.comprar(string,string,uint256)](contracts/exchange.sol#L4459-L4484) uses arbitrary from in transferFrom: [currency[_currency].transferFrom(_from,crowdfounding[_security],_amount)](contracts/exchange.sol#L4473)

contracts/exchange.sol#L4459-L4484


## arbitrary-send-eth
Impact: High
Confidence: Medium
 - [ ] ID-4
[MinimalForwarder.execute(MinimalForwarder.ForwardRequest,bytes)](contracts/exchange.sol#L4251-L4275) sends eth to arbitrary user
	Dangerous calls:
	- [(success,returndata) = req.to.call{gas: req.gas,value: req.value}(abi.encodePacked(req.data,req.from))](contracts/exchange.sol#L4258-L4260)

contracts/exchange.sol#L4251-L4275


## incorrect-exp
Impact: High
Confidence: Medium
 - [ ] ID-5
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange.sol#L3149-L3228) has bitwise-xor operator ^ instead of the exponentiation operator **: 
	 - [inverse = (3 * denominator) ^ 2](contracts/exchange.sol#L3210)

contracts/exchange.sol#L3149-L3228


## unchecked-transfer
Impact: High
Confidence: Medium
 - [ ] ID-6
[Exchange.comprar(string,string,uint256)](contracts/exchange.sol#L4459-L4484) ignores return value by [security[_security].transfer(_msgSender(),_amount)](contracts/exchange.sol#L4466)

contracts/exchange.sol#L4459-L4484


 - [ ] ID-7
[Exchange.comprar(string,string,uint256)](contracts/exchange.sol#L4459-L4484) ignores return value by [security[_security].transfer(_msgSender(),_amount)](contracts/exchange.sol#L4480)

contracts/exchange.sol#L4459-L4484


 - [ ] ID-8
[Exchange.withdraw(address,address,uint256,string)](contracts/exchange.sol#L4402-L4405) ignores return value by [currency[_tokenName].transferFrom(_from,_to,_amount)](contracts/exchange.sol#L4404)

contracts/exchange.sol#L4402-L4405


 - [ ] ID-9
[Exchange.comprar(string,string,uint256)](contracts/exchange.sol#L4459-L4484) ignores return value by [currency[_currency].transferFrom(_from,crowdfounding[_security],_amount)](contracts/exchange.sol#L4473)

contracts/exchange.sol#L4459-L4484


 - [ ] ID-10
[Exchange.comprar(string,string,uint256)](contracts/exchange.sol#L4459-L4484) ignores return value by [currency[_currency].transferFrom(_from,crowdfounding[_security],_amount)](contracts/exchange.sol#L4478)

contracts/exchange.sol#L4459-L4484


 - [ ] ID-11
[Exchange.comprar(string,string,uint256)](contracts/exchange.sol#L4459-L4484) ignores return value by [currency[_currency].transferFrom(_from,crowdfounding[_security],_amount)](contracts/exchange.sol#L4465)

contracts/exchange.sol#L4459-L4484


 - [ ] ID-12
[Exchange.comprar(string,string,uint256)](contracts/exchange.sol#L4459-L4484) ignores return value by [security[_security].transfer(_msgSender(),_amount)](contracts/exchange.sol#L4475)

contracts/exchange.sol#L4459-L4484


## divide-before-multiply
Impact: Medium
Confidence: Medium
 - [ ] ID-13
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange.sol#L3149-L3228) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/exchange.sol#L3195)
	- [inverse *= 2 - denominator * inverse](contracts/exchange.sol#L3216)

contracts/exchange.sol#L3149-L3228


 - [ ] ID-14
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange.sol#L3149-L3228) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/exchange.sol#L3195)
	- [inverse = (3 * denominator) ^ 2](contracts/exchange.sol#L3210)

contracts/exchange.sol#L3149-L3228


 - [ ] ID-15
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange.sol#L3149-L3228) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/exchange.sol#L3195)
	- [inverse *= 2 - denominator * inverse](contracts/exchange.sol#L3219)

contracts/exchange.sol#L3149-L3228


 - [ ] ID-16
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange.sol#L3149-L3228) performs a multiplication on the result of a division:
	- [prod0 = prod0 / twos](contracts/exchange.sol#L3198)
	- [result = prod0 * inverse](contracts/exchange.sol#L3225)

contracts/exchange.sol#L3149-L3228


 - [ ] ID-17
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange.sol#L3149-L3228) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/exchange.sol#L3195)
	- [inverse *= 2 - denominator * inverse](contracts/exchange.sol#L3217)

contracts/exchange.sol#L3149-L3228


 - [ ] ID-18
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange.sol#L3149-L3228) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/exchange.sol#L3195)
	- [inverse *= 2 - denominator * inverse](contracts/exchange.sol#L3218)

contracts/exchange.sol#L3149-L3228


 - [ ] ID-19
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange.sol#L3149-L3228) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/exchange.sol#L3195)
	- [inverse *= 2 - denominator * inverse](contracts/exchange.sol#L3215)

contracts/exchange.sol#L3149-L3228


 - [ ] ID-20
[Math.invMod(uint256,uint256)](contracts/exchange.sol#L3248-L3294) performs a multiplication on the result of a division:
	- [quotient = gcd / remainder](contracts/exchange.sol#L3270)
	- [(gcd,remainder) = (remainder,gcd - remainder * quotient)](contracts/exchange.sol#L3272-L3279)

contracts/exchange.sol#L3248-L3294


 - [ ] ID-21
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange.sol#L3149-L3228) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/exchange.sol#L3195)
	- [inverse *= 2 - denominator * inverse](contracts/exchange.sol#L3214)

contracts/exchange.sol#L3149-L3228


## unused-return
Impact: Medium
Confidence: Medium
 - [ ] ID-22
[ERC1967Utils.upgradeToAndCall(address,bytes)](contracts/exchange.sol#L1095-L1104) ignores return value by [Address.functionDelegateCall(newImplementation,data)](contracts/exchange.sol#L1100)

contracts/exchange.sol#L1095-L1104


 - [ ] ID-23
[ERC1967Utils.upgradeBeaconToAndCall(address,bytes)](contracts/exchange.sol#L1185-L1194) ignores return value by [Address.functionDelegateCall(IBeacon(newBeacon).implementation(),data)](contracts/exchange.sol#L1190)

contracts/exchange.sol#L1185-L1194


## return-bomb
Impact: Low
Confidence: Medium
 - [ ] ID-24
[MinimalForwarder.execute(MinimalForwarder.ForwardRequest,bytes)](contracts/exchange.sol#L4251-L4275) tries to limit the gas of an external call that controls implicit decoding
	[(success,returndata) = req.to.call{gas: req.gas,value: req.value}(abi.encodePacked(req.data,req.from))](contracts/exchange.sol#L4258-L4260)

contracts/exchange.sol#L4251-L4275


## assembly
Impact: Informational
Confidence: High
 - [ ] ID-25
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange.sol#L3149-L3228) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L3156-L3159)
	- [INLINE ASM](contracts/exchange.sol#L3180-L3187)
	- [INLINE ASM](contracts/exchange.sol#L3193-L3202)

contracts/exchange.sol#L3149-L3228


 - [ ] ID-26
[StorageSlot.getBooleanSlot(bytes32)](contracts/exchange.sol#L944-L949) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L946-L948)

contracts/exchange.sol#L944-L949


 - [ ] ID-27
[MinimalForwarder.execute(MinimalForwarder.ForwardRequest,bytes)](contracts/exchange.sol#L4251-L4275) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L4269-L4271)

contracts/exchange.sol#L4251-L4275


 - [ ] ID-28
[ECDSA.tryRecover(bytes32,bytes)](contracts/exchange.sol#L1645-L1662) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L1653-L1657)

contracts/exchange.sol#L1645-L1662


 - [ ] ID-29
[MessageHashUtils.toEthSignedMessageHash(bytes32)](contracts/exchange.sol#L3856-L3863) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L3858-L3862)

contracts/exchange.sol#L3856-L3863


 - [ ] ID-30
[StorageSlot.getStringSlot(bytes32)](contracts/exchange.sol#L974-L979) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L976-L978)

contracts/exchange.sol#L974-L979


 - [ ] ID-31
[StorageSlot.getBytesSlot(bytes32)](contracts/exchange.sol#L994-L999) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L996-L998)

contracts/exchange.sol#L994-L999


 - [ ] ID-32
[StorageSlot.getUint256Slot(bytes32)](contracts/exchange.sol#L964-L969) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L966-L968)

contracts/exchange.sol#L964-L969


 - [ ] ID-33
[AccessControlUpgradeable._getAccessControlStorage()](contracts/exchange.sol#L498-L502) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L499-L501)

contracts/exchange.sol#L498-L502


 - [ ] ID-34
[ShortStrings.toString(ShortString)](contracts/exchange.sol#L3985-L3995) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L3990-L3993)

contracts/exchange.sol#L3985-L3995


 - [ ] ID-35
[Strings.toString(uint256)](contracts/exchange.sol#L3755-L3775) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L3761-L3763)
	- [INLINE ASM](contracts/exchange.sol#L3767-L3769)

contracts/exchange.sol#L3755-L3775


 - [ ] ID-36
[StorageSlot.getBytes32Slot(bytes32)](contracts/exchange.sol#L954-L959) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L956-L958)

contracts/exchange.sol#L954-L959


 - [ ] ID-37
[MessageHashUtils.toTypedDataHash(bytes32,bytes32)](contracts/exchange.sol#L3902-L3911) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L3904-L3910)

contracts/exchange.sol#L3902-L3911


 - [ ] ID-38
[StorageSlot.getAddressSlot(bytes32)](contracts/exchange.sol#L934-L939) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L936-L938)

contracts/exchange.sol#L934-L939


 - [ ] ID-39
[Address._revert(bytes)](contracts/exchange.sol#L858-L870) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L863-L866)

contracts/exchange.sol#L858-L870


 - [ ] ID-40
[Panic.panic(uint256)](contracts/exchange.sol#L3013-L3020) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L3015-L3019)

contracts/exchange.sol#L3013-L3020


 - [ ] ID-41
[Math.tryModExp(uint256,uint256,uint256)](contracts/exchange.sol#L3327-L3352) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L3330-L3351)

contracts/exchange.sol#L3327-L3352


 - [ ] ID-42
[Math.tryModExp(bytes,bytes,bytes)](contracts/exchange.sol#L3368-L3391) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L3381-L3390)

contracts/exchange.sol#L3368-L3391


 - [ ] ID-43
[PausableUpgradeable._getPausableStorage()](contracts/exchange.sol#L1389-L1393) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L1390-L1392)

contracts/exchange.sol#L1389-L1393


 - [ ] ID-44
[SafeCast.toUint(bool)](contracts/exchange.sol#L2956-L2961) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L2958-L2960)

contracts/exchange.sol#L2956-L2961


 - [ ] ID-45
[StorageSlot.getStringSlot(string)](contracts/exchange.sol#L984-L989) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L986-L988)

contracts/exchange.sol#L984-L989


 - [ ] ID-46
[Initializable._getInitializableStorage()](contracts/exchange.sol#L221-L225) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L222-L224)

contracts/exchange.sol#L221-L225


 - [ ] ID-47
[StorageSlot.getBytesSlot(bytes)](contracts/exchange.sol#L1004-L1009) uses assembly
	- [INLINE ASM](contracts/exchange.sol#L1006-L1008)

contracts/exchange.sol#L1004-L1009


## dead-code
Impact: Informational
Confidence: Medium
 - [ ] ID-48
[Math.modExp(bytes,bytes,bytes)](contracts/exchange.sol#L3357-L3363) is never used and should be removed

contracts/exchange.sol#L3357-L3363


 - [ ] ID-49
[ContextUpgradeable._msgData()](contracts/exchange.sol#L256-L258) is never used and should be removed

contracts/exchange.sol#L256-L258


 - [ ] ID-50
[Strings.toHexString(uint256,uint256)](contracts/exchange.sol#L3796-L3809) is never used and should be removed

contracts/exchange.sol#L3796-L3809


 - [ ] ID-51
[SafeCast.toUint216(uint256)](contracts/exchange.sol#L1917-L1922) is never used and should be removed

contracts/exchange.sol#L1917-L1922


 - [ ] ID-52
[SafeCast.toUint248(uint256)](contracts/exchange.sol#L1849-L1854) is never used and should be removed

contracts/exchange.sol#L1849-L1854


 - [ ] ID-53
[SafeCast.toUint80(uint256)](contracts/exchange.sol#L2206-L2211) is never used and should be removed

contracts/exchange.sol#L2206-L2211


 - [ ] ID-54
[ERC1967Utils._setAdmin(address)](contracts/exchange.sol#L1127-L1132) is never used and should be removed

contracts/exchange.sol#L1127-L1132


 - [ ] ID-55
[SafeCast.toUint240(uint256)](contracts/exchange.sol#L1866-L1871) is never used and should be removed

contracts/exchange.sol#L1866-L1871


 - [ ] ID-56
[StorageSlot.getBytesSlot(bytes)](contracts/exchange.sol#L1004-L1009) is never used and should be removed

contracts/exchange.sol#L1004-L1009


 - [ ] ID-57
[Address.sendValue(address,uint256)](contracts/exchange.sol#L753-L762) is never used and should be removed

contracts/exchange.sol#L753-L762


 - [ ] ID-58
[Math.ceilDiv(uint256,uint256)](contracts/exchange.sol#L3126-L3140) is never used and should be removed

contracts/exchange.sol#L3126-L3140


 - [ ] ID-59
[SafeCast.toInt96(int256)](contracts/exchange.sol#L2733-L2738) is never used and should be removed

contracts/exchange.sol#L2733-L2738


 - [ ] ID-60
[Address.functionCallWithValue(address,bytes,uint256)](contracts/exchange.sol#L795-L801) is never used and should be removed

contracts/exchange.sol#L795-L801


 - [ ] ID-61
[ContextUpgradeable._contextSuffixLength()](contracts/exchange.sol#L260-L262) is never used and should be removed

contracts/exchange.sol#L260-L262


 - [ ] ID-62
[StorageSlot.getUint256Slot(bytes32)](contracts/exchange.sol#L964-L969) is never used and should be removed

contracts/exchange.sol#L964-L969


 - [ ] ID-63
[SignedMath.min(int256,int256)](contracts/exchange.sol#L3701-L3703) is never used and should be removed

contracts/exchange.sol#L3701-L3703


 - [ ] ID-64
[ERC1967Utils.upgradeBeaconToAndCall(address,bytes)](contracts/exchange.sol#L1185-L1194) is never used and should be removed

contracts/exchange.sol#L1185-L1194


 - [ ] ID-65
[SafeCast.toInt104(int256)](contracts/exchange.sol#L2715-L2720) is never used and should be removed

contracts/exchange.sol#L2715-L2720


 - [ ] ID-66
[MessageHashUtils.toDataWithIntendedValidatorHash(address,bytes)](contracts/exchange.sol#L3889-L3891) is never used and should be removed

contracts/exchange.sol#L3889-L3891


 - [ ] ID-67
[SafeCast.toUint112(uint256)](contracts/exchange.sol#L2138-L2143) is never used and should be removed

contracts/exchange.sol#L2138-L2143


 - [ ] ID-68
[StorageSlot.getStringSlot(bytes32)](contracts/exchange.sol#L974-L979) is never used and should be removed

contracts/exchange.sol#L974-L979


 - [ ] ID-69
[Math.log10(uint256,Math.Rounding)](contracts/exchange.sol#L3622-L3627) is never used and should be removed

contracts/exchange.sol#L3622-L3627


 - [ ] ID-70
[SafeCast.toUint208(uint256)](contracts/exchange.sol#L1934-L1939) is never used and should be removed

contracts/exchange.sol#L1934-L1939


 - [ ] ID-71
[SafeCast.toInt24(int256)](contracts/exchange.sol#L2895-L2900) is never used and should be removed

contracts/exchange.sol#L2895-L2900


 - [ ] ID-72
[SafeCast.toUint64(uint256)](contracts/exchange.sol#L2240-L2245) is never used and should be removed

contracts/exchange.sol#L2240-L2245


 - [ ] ID-73
[SafeCast.toUint168(uint256)](contracts/exchange.sol#L2019-L2024) is never used and should be removed

contracts/exchange.sol#L2019-L2024


 - [ ] ID-74
[SafeCast.toUint256(int256)](contracts/exchange.sol#L2373-L2378) is never used and should be removed

contracts/exchange.sol#L2373-L2378


 - [ ] ID-75
[SafeCast.toInt216(int256)](contracts/exchange.sol#L2463-L2468) is never used and should be removed

contracts/exchange.sol#L2463-L2468


 - [ ] ID-76
[ERC1967Utils.getAdmin()](contracts/exchange.sol#L1120-L1122) is never used and should be removed

contracts/exchange.sol#L1120-L1122


 - [ ] ID-77
[SafeCast.toInt248(int256)](contracts/exchange.sol#L2391-L2396) is never used and should be removed

contracts/exchange.sol#L2391-L2396


 - [ ] ID-78
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange.sol#L3149-L3228) is never used and should be removed

contracts/exchange.sol#L3149-L3228


 - [ ] ID-79
[SafeCast.toInt256(uint256)](contracts/exchange.sol#L2945-L2951) is never used and should be removed

contracts/exchange.sol#L2945-L2951


 - [ ] ID-80
[SafeCast.toInt160(int256)](contracts/exchange.sol#L2589-L2594) is never used and should be removed

contracts/exchange.sol#L2589-L2594


 - [ ] ID-81
[Math.tryDiv(uint256,uint256)](contracts/exchange.sol#L3080-L3085) is never used and should be removed

contracts/exchange.sol#L3080-L3085


 - [ ] ID-82
[SignedMath.average(int256,int256)](contracts/exchange.sol#L3709-L3713) is never used and should be removed

contracts/exchange.sol#L3709-L3713


 - [ ] ID-83
[SafeCast.toUint144(uint256)](contracts/exchange.sol#L2070-L2075) is never used and should be removed

contracts/exchange.sol#L2070-L2075


 - [ ] ID-84
[Strings.toHexString(uint256)](contracts/exchange.sol#L3787-L3791) is never used and should be removed

contracts/exchange.sol#L3787-L3791


 - [ ] ID-85
[Math._zeroBytes(bytes)](contracts/exchange.sol#L3396-L3403) is never used and should be removed

contracts/exchange.sol#L3396-L3403


 - [ ] ID-86
[SafeCast.toInt120(int256)](contracts/exchange.sol#L2679-L2684) is never used and should be removed

contracts/exchange.sol#L2679-L2684


 - [ ] ID-87
[SafeCast.toInt184(int256)](contracts/exchange.sol#L2535-L2540) is never used and should be removed

contracts/exchange.sol#L2535-L2540


 - [ ] ID-88
[Math.sqrt(uint256,Math.Rounding)](contracts/exchange.sol#L3521-L3526) is never used and should be removed

contracts/exchange.sol#L3521-L3526


 - [ ] ID-89
[ContextUpgradeable.__Context_init_unchained()](contracts/exchange.sol#L250-L251) is never used and should be removed

contracts/exchange.sol#L250-L251


 - [ ] ID-90
[Math.max(uint256,uint256)](contracts/exchange.sol#L3100-L3102) is never used and should be removed

contracts/exchange.sol#L3100-L3102


 - [ ] ID-91
[SafeCast.toUint128(uint256)](contracts/exchange.sol#L2104-L2109) is never used and should be removed

contracts/exchange.sol#L2104-L2109


 - [ ] ID-92
[SafeCast.toInt80(int256)](contracts/exchange.sol#L2769-L2774) is never used and should be removed

contracts/exchange.sol#L2769-L2774


 - [ ] ID-93
[SafeCast.toInt240(int256)](contracts/exchange.sol#L2409-L2414) is never used and should be removed

contracts/exchange.sol#L2409-L2414


 - [ ] ID-94
[Math.log2(uint256)](contracts/exchange.sol#L3532-L3567) is never used and should be removed

contracts/exchange.sol#L3532-L3567


 - [ ] ID-95
[ERC165Upgradeable.__ERC165_init_unchained()](contracts/exchange.sol#L319-L320) is never used and should be removed

contracts/exchange.sol#L319-L320


 - [ ] ID-96
[Math.average(uint256,uint256)](contracts/exchange.sol#L3115-L3118) is never used and should be removed

contracts/exchange.sol#L3115-L3118


 - [ ] ID-97
[SafeCast.toInt144(int256)](contracts/exchange.sol#L2625-L2630) is never used and should be removed

contracts/exchange.sol#L2625-L2630


 - [ ] ID-98
[SafeCast.toInt200(int256)](contracts/exchange.sol#L2499-L2504) is never used and should be removed

contracts/exchange.sol#L2499-L2504


 - [ ] ID-99
[SafeCast.toInt40(int256)](contracts/exchange.sol#L2859-L2864) is never used and should be removed

contracts/exchange.sol#L2859-L2864


 - [ ] ID-100
[Math.log2(uint256,Math.Rounding)](contracts/exchange.sol#L3573-L3578) is never used and should be removed

contracts/exchange.sol#L3573-L3578


 - [ ] ID-101
[SafeCast.toUint40(uint256)](contracts/exchange.sol#L2291-L2296) is never used and should be removed

contracts/exchange.sol#L2291-L2296


 - [ ] ID-102
[SafeCast.toInt224(int256)](contracts/exchange.sol#L2445-L2450) is never used and should be removed

contracts/exchange.sol#L2445-L2450


 - [ ] ID-103
[SafeCast.toInt208(int256)](contracts/exchange.sol#L2481-L2486) is never used and should be removed

contracts/exchange.sol#L2481-L2486


 - [ ] ID-104
[ERC1967Utils.getBeacon()](contracts/exchange.sol#L1154-L1156) is never used and should be removed

contracts/exchange.sol#L1154-L1156


 - [ ] ID-105
[SafeCast.toUint72(uint256)](contracts/exchange.sol#L2223-L2228) is never used and should be removed

contracts/exchange.sol#L2223-L2228


 - [ ] ID-106
[SafeCast.toInt88(int256)](contracts/exchange.sol#L2751-L2756) is never used and should be removed

contracts/exchange.sol#L2751-L2756


 - [ ] ID-107
[Math.log256(uint256)](contracts/exchange.sol#L3635-L3658) is never used and should be removed

contracts/exchange.sol#L3635-L3658


 - [ ] ID-108
[SafeCast.toUint(bool)](contracts/exchange.sol#L2956-L2961) is never used and should be removed

contracts/exchange.sol#L2956-L2961


 - [ ] ID-109
[SafeCast.toUint8(uint256)](contracts/exchange.sol#L2359-L2364) is never used and should be removed

contracts/exchange.sol#L2359-L2364


 - [ ] ID-110
[Strings.toString(uint256)](contracts/exchange.sol#L3755-L3775) is never used and should be removed

contracts/exchange.sol#L3755-L3775


 - [ ] ID-111
[SafeCast.toUint24(uint256)](contracts/exchange.sol#L2325-L2330) is never used and should be removed

contracts/exchange.sol#L2325-L2330


 - [ ] ID-112
[ERC1967Utils._setBeacon(address)](contracts/exchange.sol#L1161-L1172) is never used and should be removed

contracts/exchange.sol#L1161-L1172


 - [ ] ID-113
[Math.tryModExp(uint256,uint256,uint256)](contracts/exchange.sol#L3327-L3352) is never used and should be removed

contracts/exchange.sol#L3327-L3352


 - [ ] ID-114
[Math.modExp(uint256,uint256,uint256)](contracts/exchange.sol#L3309-L3315) is never used and should be removed

contracts/exchange.sol#L3309-L3315


 - [ ] ID-115
[Math.log256(uint256,Math.Rounding)](contracts/exchange.sol#L3664-L3669) is never used and should be removed

contracts/exchange.sol#L3664-L3669


 - [ ] ID-116
[SafeCast.toInt128(int256)](contracts/exchange.sol#L2661-L2666) is never used and should be removed

contracts/exchange.sol#L2661-L2666


 - [ ] ID-117
[Math.sqrt(uint256)](contracts/exchange.sol#L3412-L3516) is never used and should be removed

contracts/exchange.sol#L3412-L3516


 - [ ] ID-118
[SafeCast.toInt32(int256)](contracts/exchange.sol#L2877-L2882) is never used and should be removed

contracts/exchange.sol#L2877-L2882


 - [ ] ID-119
[SafeCast.toInt112(int256)](contracts/exchange.sol#L2697-L2702) is never used and should be removed

contracts/exchange.sol#L2697-L2702


 - [ ] ID-120
[ExchangeOverride._msgData()](contracts/exchange.sol#L4321-L4329) is never used and should be removed

contracts/exchange.sol#L4321-L4329


 - [ ] ID-121
[AccessControlUpgradeable._setRoleAdmin(bytes32,bytes32)](contracts/exchange.sol#L622-L627) is never used and should be removed

contracts/exchange.sol#L622-L627


 - [ ] ID-122
[SafeCast.toUint232(uint256)](contracts/exchange.sol#L1883-L1888) is never used and should be removed

contracts/exchange.sol#L1883-L1888


 - [ ] ID-123
[SafeCast.toInt64(int256)](contracts/exchange.sol#L2805-L2810) is never used and should be removed

contracts/exchange.sol#L2805-L2810


 - [ ] ID-124
[Math.tryAdd(uint256,uint256)](contracts/exchange.sol#L3044-L3050) is never used and should be removed

contracts/exchange.sol#L3044-L3050


 - [ ] ID-125
[Address.functionStaticCall(address,bytes)](contracts/exchange.sol#L807-L810) is never used and should be removed

contracts/exchange.sol#L807-L810


 - [ ] ID-126
[SafeCast.toInt56(int256)](contracts/exchange.sol#L2823-L2828) is never used and should be removed

contracts/exchange.sol#L2823-L2828


 - [ ] ID-127
[SafeCast.toUint104(uint256)](contracts/exchange.sol#L2155-L2160) is never used and should be removed

contracts/exchange.sol#L2155-L2160


 - [ ] ID-128
[SafeCast.toUint152(uint256)](contracts/exchange.sol#L2053-L2058) is never used and should be removed

contracts/exchange.sol#L2053-L2058


 - [ ] ID-129
[SafeCast.toInt232(int256)](contracts/exchange.sol#L2427-L2432) is never used and should be removed

contracts/exchange.sol#L2427-L2432


 - [ ] ID-130
[SafeCast.toUint224(uint256)](contracts/exchange.sol#L1900-L1905) is never used and should be removed

contracts/exchange.sol#L1900-L1905


 - [ ] ID-131
[ERC165Upgradeable.__ERC165_init()](contracts/exchange.sol#L316-L317) is never used and should be removed

contracts/exchange.sol#L316-L317


 - [ ] ID-132
[Math.mulDiv(uint256,uint256,uint256,Math.Rounding)](contracts/exchange.sol#L3233-L3235) is never used and should be removed

contracts/exchange.sol#L3233-L3235


 - [ ] ID-133
[SafeCast.toInt152(int256)](contracts/exchange.sol#L2607-L2612) is never used and should be removed

contracts/exchange.sol#L2607-L2612


 - [ ] ID-134
[SafeCast.toInt176(int256)](contracts/exchange.sol#L2553-L2558) is never used and should be removed

contracts/exchange.sol#L2553-L2558


 - [ ] ID-135
[SafeCast.toInt8(int256)](contracts/exchange.sol#L2931-L2936) is never used and should be removed

contracts/exchange.sol#L2931-L2936


 - [ ] ID-136
[Math.log10(uint256)](contracts/exchange.sol#L3584-L3616) is never used and should be removed

contracts/exchange.sol#L3584-L3616


 - [ ] ID-137
[SafeCast.toInt48(int256)](contracts/exchange.sol#L2841-L2846) is never used and should be removed

contracts/exchange.sol#L2841-L2846


 - [ ] ID-138
[SafeCast.toUint192(uint256)](contracts/exchange.sol#L1968-L1973) is never used and should be removed

contracts/exchange.sol#L1968-L1973


 - [ ] ID-139
[SafeCast.toUint200(uint256)](contracts/exchange.sol#L1951-L1956) is never used and should be removed

contracts/exchange.sol#L1951-L1956


 - [ ] ID-140
[SafeCast.toUint96(uint256)](contracts/exchange.sol#L2172-L2177) is never used and should be removed

contracts/exchange.sol#L2172-L2177


 - [ ] ID-141
[Math.tryModExp(bytes,bytes,bytes)](contracts/exchange.sol#L3368-L3391) is never used and should be removed

contracts/exchange.sol#L3368-L3391


 - [ ] ID-142
[ECDSA.tryRecover(bytes32,bytes32,bytes32)](contracts/exchange.sol#L1689-L1696) is never used and should be removed

contracts/exchange.sol#L1689-L1696


 - [ ] ID-143
[ShortStrings.byteLengthWithFallback(ShortString,string)](contracts/exchange.sol#L4038-L4044) is never used and should be removed

contracts/exchange.sol#L4038-L4044


 - [ ] ID-144
[MessageHashUtils.toEthSignedMessageHash(bytes)](contracts/exchange.sol#L3875-L3878) is never used and should be removed

contracts/exchange.sol#L3875-L3878


 - [ ] ID-145
[SafeCast.toUint184(uint256)](contracts/exchange.sol#L1985-L1990) is never used and should be removed

contracts/exchange.sol#L1985-L1990


 - [ ] ID-146
[UUPSUpgradeable.__UUPSUpgradeable_init_unchained()](contracts/exchange.sol#L1275-L1276) is never used and should be removed

contracts/exchange.sol#L1275-L1276


 - [ ] ID-147
[ERC1967Utils.changeAdmin(address)](contracts/exchange.sol#L1139-L1142) is never used and should be removed

contracts/exchange.sol#L1139-L1142


 - [ ] ID-148
[SafeCast.toUint160(uint256)](contracts/exchange.sol#L2036-L2041) is never used and should be removed

contracts/exchange.sol#L2036-L2041


 - [ ] ID-149
[StorageSlot.getStringSlot(string)](contracts/exchange.sol#L984-L989) is never used and should be removed

contracts/exchange.sol#L984-L989


 - [ ] ID-150
[ShortStrings.toShortString(string)](contracts/exchange.sol#L3974-L3980) is never used and should be removed

contracts/exchange.sol#L3974-L3980


 - [ ] ID-151
[Strings.toHexString(address)](contracts/exchange.sol#L3815-L3817) is never used and should be removed

contracts/exchange.sol#L3815-L3817


 - [ ] ID-152
[AccessControlUpgradeable.__AccessControl_init_unchained()](contracts/exchange.sol#L516-L517) is never used and should be removed

contracts/exchange.sol#L516-L517


 - [ ] ID-153
[SafeCast.toUint16(uint256)](contracts/exchange.sol#L2342-L2347) is never used and should be removed

contracts/exchange.sol#L2342-L2347


 - [ ] ID-154
[SafeCast.toInt16(int256)](contracts/exchange.sol#L2913-L2918) is never used and should be removed

contracts/exchange.sol#L2913-L2918


 - [ ] ID-155
[Initializable._getInitializedVersion()](contracts/exchange.sol#L206-L208) is never used and should be removed

contracts/exchange.sol#L206-L208


 - [ ] ID-156
[SafeCast.toInt168(int256)](contracts/exchange.sol#L2571-L2576) is never used and should be removed

contracts/exchange.sol#L2571-L2576


 - [ ] ID-157
[Strings.toStringSigned(int256)](contracts/exchange.sol#L3780-L3782) is never used and should be removed

contracts/exchange.sol#L3780-L3782


 - [ ] ID-158
[SafeCast.toUint176(uint256)](contracts/exchange.sol#L2002-L2007) is never used and should be removed

contracts/exchange.sol#L2002-L2007


 - [ ] ID-159
[SafeCast.toUint48(uint256)](contracts/exchange.sol#L2274-L2279) is never used and should be removed

contracts/exchange.sol#L2274-L2279


 - [ ] ID-160
[Math.invMod(uint256,uint256)](contracts/exchange.sol#L3248-L3294) is never used and should be removed

contracts/exchange.sol#L3248-L3294


 - [ ] ID-161
[Math.trySub(uint256,uint256)](contracts/exchange.sol#L3055-L3060) is never used and should be removed

contracts/exchange.sol#L3055-L3060


 - [ ] ID-162
[StorageSlot.getBooleanSlot(bytes32)](contracts/exchange.sol#L944-L949) is never used and should be removed

contracts/exchange.sol#L944-L949


 - [ ] ID-163
[Math.tryMul(uint256,uint256)](contracts/exchange.sol#L3065-L3075) is never used and should be removed

contracts/exchange.sol#L3065-L3075


 - [ ] ID-164
[StorageSlot.getBytes32Slot(bytes32)](contracts/exchange.sol#L954-L959) is never used and should be removed

contracts/exchange.sol#L954-L959


 - [ ] ID-165
[MessageHashUtils.toEthSignedMessageHash(bytes32)](contracts/exchange.sol#L3856-L3863) is never used and should be removed

contracts/exchange.sol#L3856-L3863


 - [ ] ID-166
[Strings.equal(string,string)](contracts/exchange.sol#L3822-L3824) is never used and should be removed

contracts/exchange.sol#L3822-L3824


 - [ ] ID-167
[SafeCast.toUint56(uint256)](contracts/exchange.sol#L2257-L2262) is never used and should be removed

contracts/exchange.sol#L2257-L2262


 - [ ] ID-168
[SafeCast.toUint88(uint256)](contracts/exchange.sol#L2189-L2194) is never used and should be removed

contracts/exchange.sol#L2189-L2194


 - [ ] ID-169
[Math.tryMod(uint256,uint256)](contracts/exchange.sol#L3090-L3095) is never used and should be removed

contracts/exchange.sol#L3090-L3095


 - [ ] ID-170
[Math.min(uint256,uint256)](contracts/exchange.sol#L3107-L3109) is never used and should be removed

contracts/exchange.sol#L3107-L3109


 - [ ] ID-171
[ECDSA.recover(bytes32,uint8,bytes32,bytes32)](contracts/exchange.sol#L1743-L1747) is never used and should be removed

contracts/exchange.sol#L1743-L1747


 - [ ] ID-172
[Address.verifyCallResult(bool,bytes)](contracts/exchange.sol#L847-L853) is never used and should be removed

contracts/exchange.sol#L847-L853


 - [ ] ID-173
[SafeCast.toInt72(int256)](contracts/exchange.sol#L2787-L2792) is never used and should be removed

contracts/exchange.sol#L2787-L2792


 - [ ] ID-174
[SignedMath.max(int256,int256)](contracts/exchange.sol#L3694-L3696) is never used and should be removed

contracts/exchange.sol#L3694-L3696


 - [ ] ID-175
[SignedMath.abs(int256)](contracts/exchange.sol#L3718-L3730) is never used and should be removed

contracts/exchange.sol#L3718-L3730


 - [ ] ID-176
[ECDSA.recover(bytes32,bytes32,bytes32)](contracts/exchange.sol#L1701-L1705) is never used and should be removed

contracts/exchange.sol#L1701-L1705


 - [ ] ID-177
[SafeCast.toUint32(uint256)](contracts/exchange.sol#L2308-L2313) is never used and should be removed

contracts/exchange.sol#L2308-L2313


 - [ ] ID-178
[SafeCast.toUint120(uint256)](contracts/exchange.sol#L2121-L2126) is never used and should be removed

contracts/exchange.sol#L2121-L2126


 - [ ] ID-179
[Math.unsignedRoundsUp(Math.Rounding)](contracts/exchange.sol#L3674-L3676) is never used and should be removed

contracts/exchange.sol#L3674-L3676


 - [ ] ID-180
[Panic.panic(uint256)](contracts/exchange.sol#L3013-L3020) is never used and should be removed

contracts/exchange.sol#L3013-L3020


 - [ ] ID-181
[ShortStrings.toShortStringWithFallback(string,string)](contracts/exchange.sol#L4011-L4018) is never used and should be removed

contracts/exchange.sol#L4011-L4018


 - [ ] ID-182
[ContextUpgradeable.__Context_init()](contracts/exchange.sol#L247-L248) is never used and should be removed

contracts/exchange.sol#L247-L248


 - [ ] ID-183
[SafeCast.toUint136(uint256)](contracts/exchange.sol#L2087-L2092) is never used and should be removed

contracts/exchange.sol#L2087-L2092


 - [ ] ID-184
[StorageSlot.getBytesSlot(bytes32)](contracts/exchange.sol#L994-L999) is never used and should be removed

contracts/exchange.sol#L994-L999


 - [ ] ID-185
[SafeCast.toInt136(int256)](contracts/exchange.sol#L2643-L2648) is never used and should be removed

contracts/exchange.sol#L2643-L2648


 - [ ] ID-186
[Address.functionCall(address,bytes)](contracts/exchange.sol#L782-L784) is never used and should be removed

contracts/exchange.sol#L782-L784


 - [ ] ID-187
[SafeCast.toInt192(int256)](contracts/exchange.sol#L2517-L2522) is never used and should be removed

contracts/exchange.sol#L2517-L2522


## solc-version
Impact: Informational
Confidence: High
 - [ ] ID-188
Version constraint ^0.8.20 contains known severe issues (https://solidity.readthedocs.io/en/latest/bugs.html)
	- VerbatimInvalidDeduplication
	- FullInlinerNonExpressionSplitArgumentEvaluationOrder
	- MissingSideEffectsOnSelectorAccess.
 It is used by:
	- contracts/exchange.sol#2

## low-level-calls
Impact: Informational
Confidence: High
 - [ ] ID-189
Low level call in [MinimalForwarder.execute(MinimalForwarder.ForwardRequest,bytes)](contracts/exchange.sol#L4251-L4275):
	- [(success,returndata) = req.to.call{gas: req.gas,value: req.value}(abi.encodePacked(req.data,req.from))](contracts/exchange.sol#L4258-L4260)

contracts/exchange.sol#L4251-L4275


 - [ ] ID-190
Low level call in [Address.sendValue(address,uint256)](contracts/exchange.sol#L753-L762):
	- [(success,None) = recipient.call{value: amount}()](contracts/exchange.sol#L758)

contracts/exchange.sol#L753-L762


 - [ ] ID-191
Low level call in [Address.functionCallWithValue(address,bytes,uint256)](contracts/exchange.sol#L795-L801):
	- [(success,returndata) = target.call{value: value}(data)](contracts/exchange.sol#L799)

contracts/exchange.sol#L795-L801


 - [ ] ID-192
Low level call in [Address.functionDelegateCall(address,bytes)](contracts/exchange.sol#L816-L819):
	- [(success,returndata) = target.delegatecall(data)](contracts/exchange.sol#L817)

contracts/exchange.sol#L816-L819


 - [ ] ID-193
Low level call in [Address.functionStaticCall(address,bytes)](contracts/exchange.sol#L807-L810):
	- [(success,returndata) = target.staticcall(data)](contracts/exchange.sol#L808)

contracts/exchange.sol#L807-L810


## naming-convention
Impact: Informational
Confidence: High
 - [ ] ID-194
Parameter [Exchange.linkBach(address[])._addr](contracts/exchange.sol#L4414) is not in mixedCase

contracts/exchange.sol#L4414


 - [ ] ID-195
Constant [AccessControlUpgradeable.AccessControlStorageLocation](contracts/exchange.sol#L496) is not in UPPER_CASE_WITH_UNDERSCORES

contracts/exchange.sol#L496


 - [ ] ID-196
Parameter [Exchange.setSecurity(string,address,address,uint8)._propiedad](contracts/exchange.sol#L4431) is not in mixedCase

contracts/exchange.sol#L4431


 - [ ] ID-197
Parameter [ExchangeOverride.isTrustedForwarder(address)._forwarder](contracts/exchange.sol#L4307) is not in mixedCase

contracts/exchange.sol#L4307


 - [ ] ID-198
Function [AccessControlUpgradeable.__AccessControl_init_unchained()](contracts/exchange.sol#L516-L517) is not in mixedCase

contracts/exchange.sol#L516-L517


 - [ ] ID-199
Parameter [Exchange.setLinkManual(address,address)._linkSemi](contracts/exchange.sol#L4453) is not in mixedCase

contracts/exchange.sol#L4453


 - [ ] ID-200
Parameter [Exchange.setWithdrawWallets(address,address)._from](contracts/exchange.sol#L4385) is not in mixedCase

contracts/exchange.sol#L4385


 - [ ] ID-201
Parameter [Exchange.comprar(string,string,uint256)._currency](contracts/exchange.sol#L4459) is not in mixedCase

contracts/exchange.sol#L4459


 - [ ] ID-202
Parameter [Exchange.withdraw(address,address,uint256,string)._from](contracts/exchange.sol#L4402) is not in mixedCase

contracts/exchange.sol#L4402


 - [ ] ID-203
Parameter [Exchange.setWithdrawWallets(address,address)._to](contracts/exchange.sol#L4385) is not in mixedCase

contracts/exchange.sol#L4385


 - [ ] ID-204
Parameter [Exchange.comprar(string,string,uint256)._amount](contracts/exchange.sol#L4459) is not in mixedCase

contracts/exchange.sol#L4459


 - [ ] ID-205
Parameter [Exchange.setSecurity(string,address,address,uint8)._decimals](contracts/exchange.sol#L4431) is not in mixedCase

contracts/exchange.sol#L4431


 - [ ] ID-206
Parameter [Exchange.checkWithdraw(address,address,uint256,string)._from](contracts/exchange.sol#L4393) is not in mixedCase

contracts/exchange.sol#L4393


 - [ ] ID-207
Function [EIP712._EIP712Version()](contracts/exchange.sol#L4201-L4203) is not in mixedCase

contracts/exchange.sol#L4201-L4203


 - [ ] ID-208
Parameter [Exchange.withdraw(address,address,uint256,string)._tokenName](contracts/exchange.sol#L4402) is not in mixedCase

contracts/exchange.sol#L4402


 - [ ] ID-209
Parameter [Exchange.checkWithdraw(address,address,uint256,string)._amount](contracts/exchange.sol#L4393) is not in mixedCase

contracts/exchange.sol#L4393


 - [ ] ID-210
Event [Exchange.whiteListed(address,address,uint256,address)](contracts/exchange.sol#L4376) is not in CapWords

contracts/exchange.sol#L4376


 - [ ] ID-211
Parameter [Exchange.setLink(address)._link](contracts/exchange.sol#L4445) is not in mixedCase

contracts/exchange.sol#L4445


 - [ ] ID-212
Parameter [Exchange.checkWithdraw(address,address,uint256,string)._tokenName](contracts/exchange.sol#L4393) is not in mixedCase

contracts/exchange.sol#L4393


 - [ ] ID-213
Parameter [ExchangeOverride.initialize(address)._forwarder](contracts/exchange.sol#L4340) is not in mixedCase

contracts/exchange.sol#L4340


 - [ ] ID-214
Parameter [Exchange.withdraw(address,address,uint256,string)._amount](contracts/exchange.sol#L4402) is not in mixedCase

contracts/exchange.sol#L4402


 - [ ] ID-215
Function [ERC165Upgradeable.__ERC165_init_unchained()](contracts/exchange.sol#L319-L320) is not in mixedCase

contracts/exchange.sol#L319-L320


 - [ ] ID-216
Function [ContextUpgradeable.__Context_init_unchained()](contracts/exchange.sol#L250-L251) is not in mixedCase

contracts/exchange.sol#L250-L251


 - [ ] ID-217
Function [UUPSUpgradeable.__UUPSUpgradeable_init_unchained()](contracts/exchange.sol#L1275-L1276) is not in mixedCase

contracts/exchange.sol#L1275-L1276


 - [ ] ID-218
Parameter [Exchange.link(address)._addr](contracts/exchange.sol#L4407) is not in mixedCase

contracts/exchange.sol#L4407


 - [ ] ID-219
Parameter [Exchange.withdraw(address,address,uint256,string)._to](contracts/exchange.sol#L4402) is not in mixedCase

contracts/exchange.sol#L4402


 - [ ] ID-220
Parameter [Exchange.setSecurity(string,address,address,uint8)._funds](contracts/exchange.sol#L4431) is not in mixedCase

contracts/exchange.sol#L4431


 - [ ] ID-221
Function [AccessControlUpgradeable.__AccessControl_init()](contracts/exchange.sol#L513-L514) is not in mixedCase

contracts/exchange.sol#L513-L514


 - [ ] ID-222
Parameter [Exchange.clearWithdrawWallets(address,address)._from](contracts/exchange.sol#L4389) is not in mixedCase

contracts/exchange.sol#L4389


 - [ ] ID-223
Parameter [Exchange.setCurrency(string,address,uint8)._addr](contracts/exchange.sol#L4439) is not in mixedCase

contracts/exchange.sol#L4439


 - [ ] ID-224
Parameter [Exchange.clearWithdrawWallets(address,address)._to](contracts/exchange.sol#L4389) is not in mixedCase

contracts/exchange.sol#L4389


 - [ ] ID-225
Parameter [Exchange.setLinkManual(address,address)._link](contracts/exchange.sol#L4453) is not in mixedCase

contracts/exchange.sol#L4453


 - [ ] ID-226
Variable [UUPSUpgradeable.__self](contracts/exchange.sol#L1229) is not in mixedCase

contracts/exchange.sol#L1229


 - [ ] ID-227
Parameter [Exchange.setCurrency(string,address,uint8)._currencyName](contracts/exchange.sol#L4439) is not in mixedCase

contracts/exchange.sol#L4439


 - [ ] ID-228
Function [UUPSUpgradeable.__UUPSUpgradeable_init()](contracts/exchange.sol#L1272-L1273) is not in mixedCase

contracts/exchange.sol#L1272-L1273


 - [ ] ID-229
Parameter [Exchange.setSecurity(string,address,address,uint8)._securityName](contracts/exchange.sol#L4431) is not in mixedCase

contracts/exchange.sol#L4431


 - [ ] ID-230
Function [EIP712._EIP712Name()](contracts/exchange.sol#L4190-L4192) is not in mixedCase

contracts/exchange.sol#L4190-L4192


 - [ ] ID-231
Function [PausableUpgradeable.__Pausable_init()](contracts/exchange.sol#L1418-L1420) is not in mixedCase

contracts/exchange.sol#L1418-L1420


 - [ ] ID-232
Parameter [Exchange.comprar(string,string,uint256)._security](contracts/exchange.sol#L4459) is not in mixedCase

contracts/exchange.sol#L4459


 - [ ] ID-233
Function [ContextUpgradeable.__Context_init()](contracts/exchange.sol#L247-L248) is not in mixedCase

contracts/exchange.sol#L247-L248


 - [ ] ID-234
Parameter [Exchange.setCurrency(string,address,uint8)._decimals](contracts/exchange.sol#L4439) is not in mixedCase

contracts/exchange.sol#L4439


 - [ ] ID-235
Function [ERC165Upgradeable.__ERC165_init()](contracts/exchange.sol#L316-L317) is not in mixedCase

contracts/exchange.sol#L316-L317


 - [ ] ID-236
Parameter [Exchange.acceptWhitelist(address)._addr](contracts/exchange.sol#L4425) is not in mixedCase

contracts/exchange.sol#L4425


 - [ ] ID-237
Constant [PausableUpgradeable.PausableStorageLocation](contracts/exchange.sol#L1387) is not in UPPER_CASE_WITH_UNDERSCORES

contracts/exchange.sol#L1387


 - [ ] ID-238
Parameter [Exchange.checkWithdraw(address,address,uint256,string)._to](contracts/exchange.sol#L4393) is not in mixedCase

contracts/exchange.sol#L4393


 - [ ] ID-239
Function [PausableUpgradeable.__Pausable_init_unchained()](contracts/exchange.sol#L1422-L1425) is not in mixedCase

contracts/exchange.sol#L1422-L1425


## too-many-digits
Impact: Informational
Confidence: Medium
 - [ ] ID-240
[ShortStrings.slitherConstructorConstantVariables()](contracts/exchange.sol#L3962-L4045) uses literals with too many digits:
	- [FALLBACK_SENTINEL = 0x00000000000000000000000000000000000000000000000000000000000000FF](contracts/exchange.sol#L3964)

contracts/exchange.sol#L3962-L4045


## unused-state
Impact: Informational
Confidence: High
 - [ ] ID-241
[Panic.GENERIC](contracts/exchange.sol#L2991) is never used in [Panic](contracts/exchange.sol#L2989-L3021)

contracts/exchange.sol#L2991


 - [ ] ID-242
[Panic.ENUM_CONVERSION_ERROR](contracts/exchange.sol#L2999) is never used in [Panic](contracts/exchange.sol#L2989-L3021)

contracts/exchange.sol#L2999


 - [ ] ID-243
[Panic.EMPTY_ARRAY_POP](contracts/exchange.sol#L3003) is never used in [Panic](contracts/exchange.sol#L2989-L3021)

contracts/exchange.sol#L3003


 - [ ] ID-244
[Panic.UNDER_OVERFLOW](contracts/exchange.sol#L2995) is never used in [Panic](contracts/exchange.sol#L2989-L3021)

contracts/exchange.sol#L2995


 - [ ] ID-245
[Panic.INVALID_INTERNAL_FUNCTION](contracts/exchange.sol#L3009) is never used in [Panic](contracts/exchange.sol#L2989-L3021)

contracts/exchange.sol#L3009


 - [ ] ID-246
[Panic.ASSERT](contracts/exchange.sol#L2993) is never used in [Panic](contracts/exchange.sol#L2989-L3021)

contracts/exchange.sol#L2993


 - [ ] ID-247
[Panic.ARRAY_OUT_OF_BOUNDS](contracts/exchange.sol#L3005) is never used in [Panic](contracts/exchange.sol#L2989-L3021)

contracts/exchange.sol#L3005


 - [ ] ID-248
[Panic.RESOURCE_ERROR](contracts/exchange.sol#L3007) is never used in [Panic](contracts/exchange.sol#L2989-L3021)

contracts/exchange.sol#L3007


 - [ ] ID-249
[Panic.STORAGE_ENCODING_ERROR](contracts/exchange.sol#L3001) is never used in [Panic](contracts/exchange.sol#L2989-L3021)

contracts/exchange.sol#L3001


 - [ ] ID-250
[Panic.DIVISION_BY_ZERO](contracts/exchange.sol#L2997) is never used in [Panic](contracts/exchange.sol#L2989-L3021)

contracts/exchange.sol#L2997


(Corregí 4 que no se veían graves pero por las dudas)