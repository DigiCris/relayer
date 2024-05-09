Summary
 - [arbitrary-send-erc20](#arbitrary-send-erc20) (3 results) (High)
 - [arbitrary-send-eth](#arbitrary-send-eth) (1 results) (High)
 - [incorrect-exp](#incorrect-exp) (1 results) (High)
 - [unchecked-transfer](#unchecked-transfer) (4 results) (High)
 - [divide-before-multiply](#divide-before-multiply) (9 results) (Medium)
 - [uninitialized-local](#uninitialized-local) (1 results) (Medium)
 - [unused-return](#unused-return) (2 results) (Medium)
 - [missing-zero-check](#missing-zero-check) (1 results) (Low) => corregido
 - [return-bomb](#return-bomb) (1 results) (Low)
 - [timestamp](#timestamp) (1 results) (Low)
 - [assembly](#assembly) (23 results) (Informational)
 - [dead-code](#dead-code) (140 results) (Informational)
 - [solc-version](#solc-version) (1 results) (Informational)
 - [low-level-calls](#low-level-calls) (5 results) (Informational)
 - [naming-convention](#naming-convention) (54 results) (Informational)
 - [too-many-digits](#too-many-digits) (2 results) (Informational)
 - [unused-state](#unused-state) (10 results) (Informational)
## arbitrary-send-erc20
Impact: High
Confidence: High
 - [ ] ID-0
[Exchange.comprar(string,string,uint256)](contracts/exchange2.sol#L4487-L4526) uses arbitrary from in transferFrom: [_token.transferFrom(_from,crowdfounding[_security],_amount)](contracts/exchange2.sol#L4513)

contracts/exchange2.sol#L4487-L4526


 - [ ] ID-1
[Exchange.withdraw(address,address,uint256,string,bool)](contracts/exchange2.sol#L4416-L4430) uses arbitrary from in transferFrom: [currency[_tokenName].transferFrom(_from,feeAddress,_feeAmount)](contracts/exchange2.sol#L4425)

contracts/exchange2.sol#L4416-L4430


 - [ ] ID-2
[Exchange.withdraw(address,address,uint256,string,bool)](contracts/exchange2.sol#L4416-L4430) uses arbitrary from in transferFrom: [currency[_tokenName].transferFrom(_from,_to,_amount)](contracts/exchange2.sol#L4428)

contracts/exchange2.sol#L4416-L4430


## arbitrary-send-eth
Impact: High
Confidence: Medium
 - [ ] ID-3
[MinimalForwarder.execute(MinimalForwarder.ForwardRequest,bytes)](contracts/exchange2.sol#L4244-L4268) sends eth to arbitrary user
	Dangerous calls:
	- [(success,returndata) = req.to.call{gas: req.gas,value: req.value}(abi.encodePacked(req.data,req.from))](contracts/exchange2.sol#L4251-L4253)

contracts/exchange2.sol#L4244-L4268


## incorrect-exp
Impact: High
Confidence: Medium
 - [ ] ID-4
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange2.sol#L3149-L3228) has bitwise-xor operator ^ instead of the exponentiation operator **: 
	 - [inverse = (3 * denominator) ^ 2](contracts/exchange2.sol#L3210)

contracts/exchange2.sol#L3149-L3228


## unchecked-transfer
Impact: High
Confidence: Medium
 - [ ] ID-5
[Exchange.comprar(string,string,uint256)](contracts/exchange2.sol#L4487-L4526) ignores return value by [_token.transferFrom(_from,crowdfounding[_security],_amount)](contracts/exchange2.sol#L4513)

contracts/exchange2.sol#L4487-L4526


 - [ ] ID-6
[Exchange.withdraw(address,address,uint256,string,bool)](contracts/exchange2.sol#L4416-L4430) ignores return value by [currency[_tokenName].transferFrom(_from,feeAddress,_feeAmount)](contracts/exchange2.sol#L4425)

contracts/exchange2.sol#L4416-L4430


 - [ ] ID-7
[Exchange.withdraw(address,address,uint256,string,bool)](contracts/exchange2.sol#L4416-L4430) ignores return value by [currency[_tokenName].transferFrom(_from,_to,_amount)](contracts/exchange2.sol#L4428)

contracts/exchange2.sol#L4416-L4430


 - [ ] ID-8
[Exchange.comprar(string,string,uint256)](contracts/exchange2.sol#L4487-L4526) ignores return value by [_project.transfer(signer,_amount)](contracts/exchange2.sol#L4514)

contracts/exchange2.sol#L4487-L4526


## divide-before-multiply
Impact: Medium
Confidence: Medium
 - [ ] ID-9
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange2.sol#L3149-L3228) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/exchange2.sol#L3195)
	- [inverse *= 2 - denominator * inverse](contracts/exchange2.sol#L3216)

contracts/exchange2.sol#L3149-L3228


 - [ ] ID-10
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange2.sol#L3149-L3228) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/exchange2.sol#L3195)
	- [inverse *= 2 - denominator * inverse](contracts/exchange2.sol#L3215)

contracts/exchange2.sol#L3149-L3228


 - [ ] ID-11
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange2.sol#L3149-L3228) performs a multiplication on the result of a division:
	- [prod0 = prod0 / twos](contracts/exchange2.sol#L3198)
	- [result = prod0 * inverse](contracts/exchange2.sol#L3225)

contracts/exchange2.sol#L3149-L3228


 - [ ] ID-12
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange2.sol#L3149-L3228) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/exchange2.sol#L3195)
	- [inverse *= 2 - denominator * inverse](contracts/exchange2.sol#L3217)

contracts/exchange2.sol#L3149-L3228


 - [ ] ID-13
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange2.sol#L3149-L3228) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/exchange2.sol#L3195)
	- [inverse *= 2 - denominator * inverse](contracts/exchange2.sol#L3218)

contracts/exchange2.sol#L3149-L3228


 - [ ] ID-14
[Math.invMod(uint256,uint256)](contracts/exchange2.sol#L3248-L3294) performs a multiplication on the result of a division:
	- [quotient = gcd / remainder](contracts/exchange2.sol#L3270)
	- [(gcd,remainder) = (remainder,gcd - remainder * quotient)](contracts/exchange2.sol#L3272-L3279)

contracts/exchange2.sol#L3248-L3294


 - [ ] ID-15
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange2.sol#L3149-L3228) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/exchange2.sol#L3195)
	- [inverse *= 2 - denominator * inverse](contracts/exchange2.sol#L3219)

contracts/exchange2.sol#L3149-L3228


 - [ ] ID-16
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange2.sol#L3149-L3228) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/exchange2.sol#L3195)
	- [inverse *= 2 - denominator * inverse](contracts/exchange2.sol#L3214)

contracts/exchange2.sol#L3149-L3228


 - [ ] ID-17
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange2.sol#L3149-L3228) performs a multiplication on the result of a division:
	- [denominator = denominator / twos](contracts/exchange2.sol#L3195)
	- [inverse = (3 * denominator) ^ 2](contracts/exchange2.sol#L3210)

contracts/exchange2.sol#L3149-L3228


## uninitialized-local
Impact: Medium
Confidence: Medium
 - [ ] ID-18
[Exchange.withdraw(address,address,uint256,string,bool)._feeAmount](contracts/exchange2.sol#L4418) is a local variable never initialized

contracts/exchange2.sol#L4418


## unused-return
Impact: Medium
Confidence: Medium
 - [ ] ID-19
[ERC1967Utils.upgradeBeaconToAndCall(address,bytes)](contracts/exchange2.sol#L1185-L1194) ignores return value by [Address.functionDelegateCall(IBeacon(newBeacon).implementation(),data)](contracts/exchange2.sol#L1190)

contracts/exchange2.sol#L1185-L1194


 - [ ] ID-20
[ERC1967Utils.upgradeToAndCall(address,bytes)](contracts/exchange2.sol#L1095-L1104) ignores return value by [Address.functionDelegateCall(newImplementation,data)](contracts/exchange2.sol#L1100)

contracts/exchange2.sol#L1095-L1104


## missing-zero-check
Impact: Low
Confidence: Medium
 - [ ] ID-21
[Exchange.setWithdrawFee(uint256,uint256,address)._feeAddress](contracts/exchange2.sol#L4432) lacks a zero-check on :
		- [feeAddress = _feeAddress](contracts/exchange2.sol#L4435)

contracts/exchange2.sol#L4432


## return-bomb
Impact: Low
Confidence: Medium
 - [ ] ID-22
[MinimalForwarder.execute(MinimalForwarder.ForwardRequest,bytes)](contracts/exchange2.sol#L4244-L4268) tries to limit the gas of an external call that controls implicit decoding
	[(success,returndata) = req.to.call{gas: req.gas,value: req.value}(abi.encodePacked(req.data,req.from))](contracts/exchange2.sol#L4251-L4253)

contracts/exchange2.sol#L4244-L4268


## timestamp
Impact: Low
Confidence: Medium
 - [ ] ID-23
[Exchange.comprar(string,string,uint256)](contracts/exchange2.sol#L4487-L4526) uses timestamp for comparisons
	Dangerous comparisons:
	- [timeStamp[_from] < (block.timestamp - 31536000)](contracts/exchange2.sol#L4499)

contracts/exchange2.sol#L4487-L4526


## assembly
Impact: Informational
Confidence: High
 - [ ] ID-24
[StorageSlot.getBytesSlot(bytes32)](contracts/exchange2.sol#L994-L999) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L996-L998)

contracts/exchange2.sol#L994-L999


 - [ ] ID-25
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange2.sol#L3149-L3228) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L3156-L3159)
	- [INLINE ASM](contracts/exchange2.sol#L3180-L3187)
	- [INLINE ASM](contracts/exchange2.sol#L3193-L3202)

contracts/exchange2.sol#L3149-L3228


 - [ ] ID-26
[StorageSlot.getStringSlot(string)](contracts/exchange2.sol#L984-L989) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L986-L988)

contracts/exchange2.sol#L984-L989


 - [ ] ID-27
[ShortStrings.toString(ShortString)](contracts/exchange2.sol#L3978-L3988) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L3983-L3986)

contracts/exchange2.sol#L3978-L3988


 - [ ] ID-28
[StorageSlot.getUint256Slot(bytes32)](contracts/exchange2.sol#L964-L969) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L966-L968)

contracts/exchange2.sol#L964-L969


 - [ ] ID-29
[MessageHashUtils.toEthSignedMessageHash(bytes32)](contracts/exchange2.sol#L3856-L3863) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L3858-L3862)

contracts/exchange2.sol#L3856-L3863


 - [ ] ID-30
[Initializable._getInitializableStorage()](contracts/exchange2.sol#L221-L225) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L222-L224)

contracts/exchange2.sol#L221-L225


 - [ ] ID-31
[AccessControlUpgradeable._getAccessControlStorage()](contracts/exchange2.sol#L498-L502) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L499-L501)

contracts/exchange2.sol#L498-L502


 - [ ] ID-32
[PausableUpgradeable._getPausableStorage()](contracts/exchange2.sol#L1389-L1393) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L1390-L1392)

contracts/exchange2.sol#L1389-L1393


 - [ ] ID-33
[StorageSlot.getBytesSlot(bytes)](contracts/exchange2.sol#L1004-L1009) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L1006-L1008)

contracts/exchange2.sol#L1004-L1009


 - [ ] ID-34
[MessageHashUtils.toTypedDataHash(bytes32,bytes32)](contracts/exchange2.sol#L3902-L3911) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L3904-L3910)

contracts/exchange2.sol#L3902-L3911


 - [ ] ID-35
[StorageSlot.getAddressSlot(bytes32)](contracts/exchange2.sol#L934-L939) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L936-L938)

contracts/exchange2.sol#L934-L939


 - [ ] ID-36
[Panic.panic(uint256)](contracts/exchange2.sol#L3013-L3020) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L3015-L3019)

contracts/exchange2.sol#L3013-L3020


 - [ ] ID-37
[SafeCast.toUint(bool)](contracts/exchange2.sol#L2956-L2961) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L2958-L2960)

contracts/exchange2.sol#L2956-L2961


 - [ ] ID-38
[Math.tryModExp(uint256,uint256,uint256)](contracts/exchange2.sol#L3327-L3352) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L3330-L3351)

contracts/exchange2.sol#L3327-L3352


 - [ ] ID-39
[MinimalForwarder.execute(MinimalForwarder.ForwardRequest,bytes)](contracts/exchange2.sol#L4244-L4268) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L4262-L4264)

contracts/exchange2.sol#L4244-L4268


 - [ ] ID-40
[ECDSA.tryRecover(bytes32,bytes)](contracts/exchange2.sol#L1645-L1662) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L1653-L1657)

contracts/exchange2.sol#L1645-L1662


 - [ ] ID-41
[StorageSlot.getBytes32Slot(bytes32)](contracts/exchange2.sol#L954-L959) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L956-L958)

contracts/exchange2.sol#L954-L959


 - [ ] ID-42
[Strings.toString(uint256)](contracts/exchange2.sol#L3755-L3775) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L3761-L3763)
	- [INLINE ASM](contracts/exchange2.sol#L3767-L3769)

contracts/exchange2.sol#L3755-L3775


 - [ ] ID-43
[Address._revert(bytes)](contracts/exchange2.sol#L858-L870) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L863-L866)

contracts/exchange2.sol#L858-L870


 - [ ] ID-44
[StorageSlot.getBooleanSlot(bytes32)](contracts/exchange2.sol#L944-L949) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L946-L948)

contracts/exchange2.sol#L944-L949


 - [ ] ID-45
[Math.tryModExp(bytes,bytes,bytes)](contracts/exchange2.sol#L3368-L3391) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L3381-L3390)

contracts/exchange2.sol#L3368-L3391


 - [ ] ID-46
[StorageSlot.getStringSlot(bytes32)](contracts/exchange2.sol#L974-L979) uses assembly
	- [INLINE ASM](contracts/exchange2.sol#L976-L978)

contracts/exchange2.sol#L974-L979


## dead-code
Impact: Informational
Confidence: Medium
 - [ ] ID-47
[Math.modExp(bytes,bytes,bytes)](contracts/exchange2.sol#L3357-L3363) is never used and should be removed

contracts/exchange2.sol#L3357-L3363


 - [ ] ID-48
[ContextUpgradeable._msgData()](contracts/exchange2.sol#L256-L258) is never used and should be removed

contracts/exchange2.sol#L256-L258


 - [ ] ID-49
[Strings.toHexString(uint256,uint256)](contracts/exchange2.sol#L3796-L3809) is never used and should be removed

contracts/exchange2.sol#L3796-L3809


 - [ ] ID-50
[SafeCast.toUint216(uint256)](contracts/exchange2.sol#L1917-L1922) is never used and should be removed

contracts/exchange2.sol#L1917-L1922


 - [ ] ID-51
[SafeCast.toUint248(uint256)](contracts/exchange2.sol#L1849-L1854) is never used and should be removed

contracts/exchange2.sol#L1849-L1854


 - [ ] ID-52
[SafeCast.toUint80(uint256)](contracts/exchange2.sol#L2206-L2211) is never used and should be removed

contracts/exchange2.sol#L2206-L2211


 - [ ] ID-53
[ERC1967Utils._setAdmin(address)](contracts/exchange2.sol#L1127-L1132) is never used and should be removed

contracts/exchange2.sol#L1127-L1132


 - [ ] ID-54
[SafeCast.toUint240(uint256)](contracts/exchange2.sol#L1866-L1871) is never used and should be removed

contracts/exchange2.sol#L1866-L1871


 - [ ] ID-55
[StorageSlot.getBytesSlot(bytes)](contracts/exchange2.sol#L1004-L1009) is never used and should be removed

contracts/exchange2.sol#L1004-L1009


 - [ ] ID-56
[Address.sendValue(address,uint256)](contracts/exchange2.sol#L753-L762) is never used and should be removed

contracts/exchange2.sol#L753-L762


 - [ ] ID-57
[Math.ceilDiv(uint256,uint256)](contracts/exchange2.sol#L3126-L3140) is never used and should be removed

contracts/exchange2.sol#L3126-L3140


 - [ ] ID-58
[SafeCast.toInt96(int256)](contracts/exchange2.sol#L2733-L2738) is never used and should be removed

contracts/exchange2.sol#L2733-L2738


 - [ ] ID-59
[Address.functionCallWithValue(address,bytes,uint256)](contracts/exchange2.sol#L795-L801) is never used and should be removed

contracts/exchange2.sol#L795-L801


 - [ ] ID-60
[ContextUpgradeable._contextSuffixLength()](contracts/exchange2.sol#L260-L262) is never used and should be removed

contracts/exchange2.sol#L260-L262


 - [ ] ID-61
[StorageSlot.getUint256Slot(bytes32)](contracts/exchange2.sol#L964-L969) is never used and should be removed

contracts/exchange2.sol#L964-L969


 - [ ] ID-62
[SignedMath.min(int256,int256)](contracts/exchange2.sol#L3701-L3703) is never used and should be removed

contracts/exchange2.sol#L3701-L3703


 - [ ] ID-63
[ERC1967Utils.upgradeBeaconToAndCall(address,bytes)](contracts/exchange2.sol#L1185-L1194) is never used and should be removed

contracts/exchange2.sol#L1185-L1194


 - [ ] ID-64
[SafeCast.toInt104(int256)](contracts/exchange2.sol#L2715-L2720) is never used and should be removed

contracts/exchange2.sol#L2715-L2720


 - [ ] ID-65
[MessageHashUtils.toDataWithIntendedValidatorHash(address,bytes)](contracts/exchange2.sol#L3889-L3891) is never used and should be removed

contracts/exchange2.sol#L3889-L3891


 - [ ] ID-66
[SafeCast.toUint112(uint256)](contracts/exchange2.sol#L2138-L2143) is never used and should be removed

contracts/exchange2.sol#L2138-L2143


 - [ ] ID-67
[StorageSlot.getStringSlot(bytes32)](contracts/exchange2.sol#L974-L979) is never used and should be removed

contracts/exchange2.sol#L974-L979


 - [ ] ID-68
[Math.log10(uint256,Math.Rounding)](contracts/exchange2.sol#L3622-L3627) is never used and should be removed

contracts/exchange2.sol#L3622-L3627


 - [ ] ID-69
[SafeCast.toUint208(uint256)](contracts/exchange2.sol#L1934-L1939) is never used and should be removed

contracts/exchange2.sol#L1934-L1939


 - [ ] ID-70
[SafeCast.toInt24(int256)](contracts/exchange2.sol#L2895-L2900) is never used and should be removed

contracts/exchange2.sol#L2895-L2900


 - [ ] ID-71
[SafeCast.toUint64(uint256)](contracts/exchange2.sol#L2240-L2245) is never used and should be removed

contracts/exchange2.sol#L2240-L2245


 - [ ] ID-72
[SafeCast.toUint168(uint256)](contracts/exchange2.sol#L2019-L2024) is never used and should be removed

contracts/exchange2.sol#L2019-L2024


 - [ ] ID-73
[SafeCast.toUint256(int256)](contracts/exchange2.sol#L2373-L2378) is never used and should be removed

contracts/exchange2.sol#L2373-L2378


 - [ ] ID-74
[SafeCast.toInt216(int256)](contracts/exchange2.sol#L2463-L2468) is never used and should be removed

contracts/exchange2.sol#L2463-L2468


 - [ ] ID-75
[ERC1967Utils.getAdmin()](contracts/exchange2.sol#L1120-L1122) is never used and should be removed

contracts/exchange2.sol#L1120-L1122


 - [ ] ID-76
[SafeCast.toInt248(int256)](contracts/exchange2.sol#L2391-L2396) is never used and should be removed

contracts/exchange2.sol#L2391-L2396


 - [ ] ID-77
[Math.mulDiv(uint256,uint256,uint256)](contracts/exchange2.sol#L3149-L3228) is never used and should be removed

contracts/exchange2.sol#L3149-L3228


 - [ ] ID-78
[SafeCast.toInt256(uint256)](contracts/exchange2.sol#L2945-L2951) is never used and should be removed

contracts/exchange2.sol#L2945-L2951


 - [ ] ID-79
[SafeCast.toInt160(int256)](contracts/exchange2.sol#L2589-L2594) is never used and should be removed

contracts/exchange2.sol#L2589-L2594


 - [ ] ID-80
[Math.tryDiv(uint256,uint256)](contracts/exchange2.sol#L3080-L3085) is never used and should be removed

contracts/exchange2.sol#L3080-L3085


 - [ ] ID-81
[SignedMath.average(int256,int256)](contracts/exchange2.sol#L3709-L3713) is never used and should be removed

contracts/exchange2.sol#L3709-L3713


 - [ ] ID-82
[SafeCast.toUint144(uint256)](contracts/exchange2.sol#L2070-L2075) is never used and should be removed

contracts/exchange2.sol#L2070-L2075


 - [ ] ID-83
[Strings.toHexString(uint256)](contracts/exchange2.sol#L3787-L3791) is never used and should be removed

contracts/exchange2.sol#L3787-L3791


 - [ ] ID-84
[Math._zeroBytes(bytes)](contracts/exchange2.sol#L3396-L3403) is never used and should be removed

contracts/exchange2.sol#L3396-L3403


 - [ ] ID-85
[SafeCast.toInt120(int256)](contracts/exchange2.sol#L2679-L2684) is never used and should be removed

contracts/exchange2.sol#L2679-L2684


 - [ ] ID-86
[SafeCast.toInt184(int256)](contracts/exchange2.sol#L2535-L2540) is never used and should be removed

contracts/exchange2.sol#L2535-L2540


 - [ ] ID-87
[Math.sqrt(uint256,Math.Rounding)](contracts/exchange2.sol#L3521-L3526) is never used and should be removed

contracts/exchange2.sol#L3521-L3526


 - [ ] ID-88
[ContextUpgradeable.__Context_init_unchained()](contracts/exchange2.sol#L250-L251) is never used and should be removed

contracts/exchange2.sol#L250-L251


 - [ ] ID-89
[Math.max(uint256,uint256)](contracts/exchange2.sol#L3100-L3102) is never used and should be removed

contracts/exchange2.sol#L3100-L3102


 - [ ] ID-90
[SafeCast.toUint128(uint256)](contracts/exchange2.sol#L2104-L2109) is never used and should be removed

contracts/exchange2.sol#L2104-L2109


 - [ ] ID-91
[SafeCast.toInt80(int256)](contracts/exchange2.sol#L2769-L2774) is never used and should be removed

contracts/exchange2.sol#L2769-L2774


 - [ ] ID-92
[SafeCast.toInt240(int256)](contracts/exchange2.sol#L2409-L2414) is never used and should be removed

contracts/exchange2.sol#L2409-L2414


 - [ ] ID-93
[Math.log2(uint256)](contracts/exchange2.sol#L3532-L3567) is never used and should be removed

contracts/exchange2.sol#L3532-L3567


 - [ ] ID-94
[ERC165Upgradeable.__ERC165_init_unchained()](contracts/exchange2.sol#L319-L320) is never used and should be removed

contracts/exchange2.sol#L319-L320


 - [ ] ID-95
[Math.average(uint256,uint256)](contracts/exchange2.sol#L3115-L3118) is never used and should be removed

contracts/exchange2.sol#L3115-L3118


 - [ ] ID-96
[SafeCast.toInt144(int256)](contracts/exchange2.sol#L2625-L2630) is never used and should be removed

contracts/exchange2.sol#L2625-L2630


 - [ ] ID-97
[SafeCast.toInt200(int256)](contracts/exchange2.sol#L2499-L2504) is never used and should be removed

contracts/exchange2.sol#L2499-L2504


 - [ ] ID-98
[SafeCast.toInt40(int256)](contracts/exchange2.sol#L2859-L2864) is never used and should be removed

contracts/exchange2.sol#L2859-L2864


 - [ ] ID-99
[Math.log2(uint256,Math.Rounding)](contracts/exchange2.sol#L3573-L3578) is never used and should be removed

contracts/exchange2.sol#L3573-L3578


 - [ ] ID-100
[SafeCast.toUint40(uint256)](contracts/exchange2.sol#L2291-L2296) is never used and should be removed

contracts/exchange2.sol#L2291-L2296


 - [ ] ID-101
[SafeCast.toInt224(int256)](contracts/exchange2.sol#L2445-L2450) is never used and should be removed

contracts/exchange2.sol#L2445-L2450


 - [ ] ID-102
[SafeCast.toInt208(int256)](contracts/exchange2.sol#L2481-L2486) is never used and should be removed

contracts/exchange2.sol#L2481-L2486


 - [ ] ID-103
[ERC1967Utils.getBeacon()](contracts/exchange2.sol#L1154-L1156) is never used and should be removed

contracts/exchange2.sol#L1154-L1156


 - [ ] ID-104
[SafeCast.toUint72(uint256)](contracts/exchange2.sol#L2223-L2228) is never used and should be removed

contracts/exchange2.sol#L2223-L2228


 - [ ] ID-105
[SafeCast.toInt88(int256)](contracts/exchange2.sol#L2751-L2756) is never used and should be removed

contracts/exchange2.sol#L2751-L2756


 - [ ] ID-106
[Math.log256(uint256)](contracts/exchange2.sol#L3635-L3658) is never used and should be removed

contracts/exchange2.sol#L3635-L3658


 - [ ] ID-107
[SafeCast.toUint(bool)](contracts/exchange2.sol#L2956-L2961) is never used and should be removed

contracts/exchange2.sol#L2956-L2961


 - [ ] ID-108
[SafeCast.toUint8(uint256)](contracts/exchange2.sol#L2359-L2364) is never used and should be removed

contracts/exchange2.sol#L2359-L2364


 - [ ] ID-109
[Strings.toString(uint256)](contracts/exchange2.sol#L3755-L3775) is never used and should be removed

contracts/exchange2.sol#L3755-L3775


 - [ ] ID-110
[SafeCast.toUint24(uint256)](contracts/exchange2.sol#L2325-L2330) is never used and should be removed

contracts/exchange2.sol#L2325-L2330


 - [ ] ID-111
[ERC1967Utils._setBeacon(address)](contracts/exchange2.sol#L1161-L1172) is never used and should be removed

contracts/exchange2.sol#L1161-L1172


 - [ ] ID-112
[Math.tryModExp(uint256,uint256,uint256)](contracts/exchange2.sol#L3327-L3352) is never used and should be removed

contracts/exchange2.sol#L3327-L3352


 - [ ] ID-113
[Math.modExp(uint256,uint256,uint256)](contracts/exchange2.sol#L3309-L3315) is never used and should be removed

contracts/exchange2.sol#L3309-L3315


 - [ ] ID-114
[Math.log256(uint256,Math.Rounding)](contracts/exchange2.sol#L3664-L3669) is never used and should be removed

contracts/exchange2.sol#L3664-L3669


 - [ ] ID-115
[SafeCast.toInt128(int256)](contracts/exchange2.sol#L2661-L2666) is never used and should be removed

contracts/exchange2.sol#L2661-L2666


 - [ ] ID-116
[Math.sqrt(uint256)](contracts/exchange2.sol#L3412-L3516) is never used and should be removed

contracts/exchange2.sol#L3412-L3516


 - [ ] ID-117
[SafeCast.toInt32(int256)](contracts/exchange2.sol#L2877-L2882) is never used and should be removed

contracts/exchange2.sol#L2877-L2882


 - [ ] ID-118
[SafeCast.toInt112(int256)](contracts/exchange2.sol#L2697-L2702) is never used and should be removed

contracts/exchange2.sol#L2697-L2702


 - [ ] ID-119
[ExchangeOverride._msgData()](contracts/exchange2.sol#L4328-L4336) is never used and should be removed

contracts/exchange2.sol#L4328-L4336


 - [ ] ID-120
[AccessControlUpgradeable._setRoleAdmin(bytes32,bytes32)](contracts/exchange2.sol#L622-L627) is never used and should be removed

contracts/exchange2.sol#L622-L627


 - [ ] ID-121
[SafeCast.toUint232(uint256)](contracts/exchange2.sol#L1883-L1888) is never used and should be removed

contracts/exchange2.sol#L1883-L1888


 - [ ] ID-122
[SafeCast.toInt64(int256)](contracts/exchange2.sol#L2805-L2810) is never used and should be removed

contracts/exchange2.sol#L2805-L2810


 - [ ] ID-123
[Math.tryAdd(uint256,uint256)](contracts/exchange2.sol#L3044-L3050) is never used and should be removed

contracts/exchange2.sol#L3044-L3050


 - [ ] ID-124
[Address.functionStaticCall(address,bytes)](contracts/exchange2.sol#L807-L810) is never used and should be removed

contracts/exchange2.sol#L807-L810


 - [ ] ID-125
[SafeCast.toInt56(int256)](contracts/exchange2.sol#L2823-L2828) is never used and should be removed

contracts/exchange2.sol#L2823-L2828


 - [ ] ID-126
[SafeCast.toUint104(uint256)](contracts/exchange2.sol#L2155-L2160) is never used and should be removed

contracts/exchange2.sol#L2155-L2160


 - [ ] ID-127
[SafeCast.toUint152(uint256)](contracts/exchange2.sol#L2053-L2058) is never used and should be removed

contracts/exchange2.sol#L2053-L2058


 - [ ] ID-128
[SafeCast.toInt232(int256)](contracts/exchange2.sol#L2427-L2432) is never used and should be removed

contracts/exchange2.sol#L2427-L2432


 - [ ] ID-129
[SafeCast.toUint224(uint256)](contracts/exchange2.sol#L1900-L1905) is never used and should be removed

contracts/exchange2.sol#L1900-L1905


 - [ ] ID-130
[ERC165Upgradeable.__ERC165_init()](contracts/exchange2.sol#L316-L317) is never used and should be removed

contracts/exchange2.sol#L316-L317


 - [ ] ID-131
[Math.mulDiv(uint256,uint256,uint256,Math.Rounding)](contracts/exchange2.sol#L3233-L3235) is never used and should be removed

contracts/exchange2.sol#L3233-L3235


 - [ ] ID-132
[SafeCast.toInt152(int256)](contracts/exchange2.sol#L2607-L2612) is never used and should be removed

contracts/exchange2.sol#L2607-L2612


 - [ ] ID-133
[SafeCast.toInt176(int256)](contracts/exchange2.sol#L2553-L2558) is never used and should be removed

contracts/exchange2.sol#L2553-L2558


 - [ ] ID-134
[SafeCast.toInt8(int256)](contracts/exchange2.sol#L2931-L2936) is never used and should be removed

contracts/exchange2.sol#L2931-L2936


 - [ ] ID-135
[Math.log10(uint256)](contracts/exchange2.sol#L3584-L3616) is never used and should be removed

contracts/exchange2.sol#L3584-L3616


 - [ ] ID-136
[SafeCast.toInt48(int256)](contracts/exchange2.sol#L2841-L2846) is never used and should be removed

contracts/exchange2.sol#L2841-L2846


 - [ ] ID-137
[SafeCast.toUint192(uint256)](contracts/exchange2.sol#L1968-L1973) is never used and should be removed

contracts/exchange2.sol#L1968-L1973


 - [ ] ID-138
[SafeCast.toUint200(uint256)](contracts/exchange2.sol#L1951-L1956) is never used and should be removed

contracts/exchange2.sol#L1951-L1956


 - [ ] ID-139
[SafeCast.toUint96(uint256)](contracts/exchange2.sol#L2172-L2177) is never used and should be removed

contracts/exchange2.sol#L2172-L2177


 - [ ] ID-140
[Math.tryModExp(bytes,bytes,bytes)](contracts/exchange2.sol#L3368-L3391) is never used and should be removed

contracts/exchange2.sol#L3368-L3391


 - [ ] ID-141
[ECDSA.tryRecover(bytes32,bytes32,bytes32)](contracts/exchange2.sol#L1689-L1696) is never used and should be removed

contracts/exchange2.sol#L1689-L1696


 - [ ] ID-142
[ShortStrings.byteLengthWithFallback(ShortString,string)](contracts/exchange2.sol#L4031-L4037) is never used and should be removed

contracts/exchange2.sol#L4031-L4037


 - [ ] ID-143
[MessageHashUtils.toEthSignedMessageHash(bytes)](contracts/exchange2.sol#L3875-L3878) is never used and should be removed

contracts/exchange2.sol#L3875-L3878


 - [ ] ID-144
[SafeCast.toUint184(uint256)](contracts/exchange2.sol#L1985-L1990) is never used and should be removed

contracts/exchange2.sol#L1985-L1990


 - [ ] ID-145
[UUPSUpgradeable.__UUPSUpgradeable_init_unchained()](contracts/exchange2.sol#L1275-L1276) is never used and should be removed

contracts/exchange2.sol#L1275-L1276


 - [ ] ID-146
[ERC1967Utils.changeAdmin(address)](contracts/exchange2.sol#L1139-L1142) is never used and should be removed

contracts/exchange2.sol#L1139-L1142


 - [ ] ID-147
[SafeCast.toUint160(uint256)](contracts/exchange2.sol#L2036-L2041) is never used and should be removed

contracts/exchange2.sol#L2036-L2041


 - [ ] ID-148
[StorageSlot.getStringSlot(string)](contracts/exchange2.sol#L984-L989) is never used and should be removed

contracts/exchange2.sol#L984-L989


 - [ ] ID-149
[ShortStrings.toShortString(string)](contracts/exchange2.sol#L3967-L3973) is never used and should be removed

contracts/exchange2.sol#L3967-L3973


 - [ ] ID-150
[Strings.toHexString(address)](contracts/exchange2.sol#L3815-L3817) is never used and should be removed

contracts/exchange2.sol#L3815-L3817


 - [ ] ID-151
[AccessControlUpgradeable.__AccessControl_init_unchained()](contracts/exchange2.sol#L516-L517) is never used and should be removed

contracts/exchange2.sol#L516-L517


 - [ ] ID-152
[SafeCast.toUint16(uint256)](contracts/exchange2.sol#L2342-L2347) is never used and should be removed

contracts/exchange2.sol#L2342-L2347


 - [ ] ID-153
[SafeCast.toInt16(int256)](contracts/exchange2.sol#L2913-L2918) is never used and should be removed

contracts/exchange2.sol#L2913-L2918


 - [ ] ID-154
[Initializable._getInitializedVersion()](contracts/exchange2.sol#L206-L208) is never used and should be removed

contracts/exchange2.sol#L206-L208


 - [ ] ID-155
[SafeCast.toInt168(int256)](contracts/exchange2.sol#L2571-L2576) is never used and should be removed

contracts/exchange2.sol#L2571-L2576


 - [ ] ID-156
[Strings.toStringSigned(int256)](contracts/exchange2.sol#L3780-L3782) is never used and should be removed

contracts/exchange2.sol#L3780-L3782


 - [ ] ID-157
[SafeCast.toUint176(uint256)](contracts/exchange2.sol#L2002-L2007) is never used and should be removed

contracts/exchange2.sol#L2002-L2007


 - [ ] ID-158
[SafeCast.toUint48(uint256)](contracts/exchange2.sol#L2274-L2279) is never used and should be removed

contracts/exchange2.sol#L2274-L2279


 - [ ] ID-159
[Math.invMod(uint256,uint256)](contracts/exchange2.sol#L3248-L3294) is never used and should be removed

contracts/exchange2.sol#L3248-L3294


 - [ ] ID-160
[Math.trySub(uint256,uint256)](contracts/exchange2.sol#L3055-L3060) is never used and should be removed

contracts/exchange2.sol#L3055-L3060


 - [ ] ID-161
[StorageSlot.getBooleanSlot(bytes32)](contracts/exchange2.sol#L944-L949) is never used and should be removed

contracts/exchange2.sol#L944-L949


 - [ ] ID-162
[Math.tryMul(uint256,uint256)](contracts/exchange2.sol#L3065-L3075) is never used and should be removed

contracts/exchange2.sol#L3065-L3075


 - [ ] ID-163
[StorageSlot.getBytes32Slot(bytes32)](contracts/exchange2.sol#L954-L959) is never used and should be removed

contracts/exchange2.sol#L954-L959


 - [ ] ID-164
[MessageHashUtils.toEthSignedMessageHash(bytes32)](contracts/exchange2.sol#L3856-L3863) is never used and should be removed

contracts/exchange2.sol#L3856-L3863


 - [ ] ID-165
[Strings.equal(string,string)](contracts/exchange2.sol#L3822-L3824) is never used and should be removed

contracts/exchange2.sol#L3822-L3824


 - [ ] ID-166
[SafeCast.toUint56(uint256)](contracts/exchange2.sol#L2257-L2262) is never used and should be removed

contracts/exchange2.sol#L2257-L2262


 - [ ] ID-167
[SafeCast.toUint88(uint256)](contracts/exchange2.sol#L2189-L2194) is never used and should be removed

contracts/exchange2.sol#L2189-L2194


 - [ ] ID-168
[Math.tryMod(uint256,uint256)](contracts/exchange2.sol#L3090-L3095) is never used and should be removed

contracts/exchange2.sol#L3090-L3095


 - [ ] ID-169
[Math.min(uint256,uint256)](contracts/exchange2.sol#L3107-L3109) is never used and should be removed

contracts/exchange2.sol#L3107-L3109


 - [ ] ID-170
[ECDSA.recover(bytes32,uint8,bytes32,bytes32)](contracts/exchange2.sol#L1743-L1747) is never used and should be removed

contracts/exchange2.sol#L1743-L1747


 - [ ] ID-171
[Address.verifyCallResult(bool,bytes)](contracts/exchange2.sol#L847-L853) is never used and should be removed

contracts/exchange2.sol#L847-L853


 - [ ] ID-172
[SafeCast.toInt72(int256)](contracts/exchange2.sol#L2787-L2792) is never used and should be removed

contracts/exchange2.sol#L2787-L2792


 - [ ] ID-173
[SignedMath.max(int256,int256)](contracts/exchange2.sol#L3694-L3696) is never used and should be removed

contracts/exchange2.sol#L3694-L3696


 - [ ] ID-174
[SignedMath.abs(int256)](contracts/exchange2.sol#L3718-L3730) is never used and should be removed

contracts/exchange2.sol#L3718-L3730


 - [ ] ID-175
[ECDSA.recover(bytes32,bytes32,bytes32)](contracts/exchange2.sol#L1701-L1705) is never used and should be removed

contracts/exchange2.sol#L1701-L1705


 - [ ] ID-176
[SafeCast.toUint32(uint256)](contracts/exchange2.sol#L2308-L2313) is never used and should be removed

contracts/exchange2.sol#L2308-L2313


 - [ ] ID-177
[SafeCast.toUint120(uint256)](contracts/exchange2.sol#L2121-L2126) is never used and should be removed

contracts/exchange2.sol#L2121-L2126


 - [ ] ID-178
[Math.unsignedRoundsUp(Math.Rounding)](contracts/exchange2.sol#L3674-L3676) is never used and should be removed

contracts/exchange2.sol#L3674-L3676


 - [ ] ID-179
[Panic.panic(uint256)](contracts/exchange2.sol#L3013-L3020) is never used and should be removed

contracts/exchange2.sol#L3013-L3020


 - [ ] ID-180
[ShortStrings.toShortStringWithFallback(string,string)](contracts/exchange2.sol#L4004-L4011) is never used and should be removed

contracts/exchange2.sol#L4004-L4011


 - [ ] ID-181
[ContextUpgradeable.__Context_init()](contracts/exchange2.sol#L247-L248) is never used and should be removed

contracts/exchange2.sol#L247-L248


 - [ ] ID-182
[SafeCast.toUint136(uint256)](contracts/exchange2.sol#L2087-L2092) is never used and should be removed

contracts/exchange2.sol#L2087-L2092


 - [ ] ID-183
[StorageSlot.getBytesSlot(bytes32)](contracts/exchange2.sol#L994-L999) is never used and should be removed

contracts/exchange2.sol#L994-L999


 - [ ] ID-184
[SafeCast.toInt136(int256)](contracts/exchange2.sol#L2643-L2648) is never used and should be removed

contracts/exchange2.sol#L2643-L2648


 - [ ] ID-185
[Address.functionCall(address,bytes)](contracts/exchange2.sol#L782-L784) is never used and should be removed

contracts/exchange2.sol#L782-L784


 - [ ] ID-186
[SafeCast.toInt192(int256)](contracts/exchange2.sol#L2517-L2522) is never used and should be removed

contracts/exchange2.sol#L2517-L2522


## solc-version
Impact: Informational
Confidence: High
 - [ ] ID-187
Version constraint ^0.8.20 contains known severe issues (https://solidity.readthedocs.io/en/latest/bugs.html)
	- VerbatimInvalidDeduplication
	- FullInlinerNonExpressionSplitArgumentEvaluationOrder
	- MissingSideEffectsOnSelectorAccess.
 It is used by:
	- contracts/exchange2.sol#2

## low-level-calls
Impact: Informational
Confidence: High
 - [ ] ID-188
Low level call in [Address.sendValue(address,uint256)](contracts/exchange2.sol#L753-L762):
	- [(success,None) = recipient.call{value: amount}()](contracts/exchange2.sol#L758)

contracts/exchange2.sol#L753-L762


 - [ ] ID-189
Low level call in [Address.functionStaticCall(address,bytes)](contracts/exchange2.sol#L807-L810):
	- [(success,returndata) = target.staticcall(data)](contracts/exchange2.sol#L808)

contracts/exchange2.sol#L807-L810


 - [ ] ID-190
Low level call in [Address.functionDelegateCall(address,bytes)](contracts/exchange2.sol#L816-L819):
	- [(success,returndata) = target.delegatecall(data)](contracts/exchange2.sol#L817)

contracts/exchange2.sol#L816-L819


 - [ ] ID-191
Low level call in [MinimalForwarder.execute(MinimalForwarder.ForwardRequest,bytes)](contracts/exchange2.sol#L4244-L4268):
	- [(success,returndata) = req.to.call{gas: req.gas,value: req.value}(abi.encodePacked(req.data,req.from))](contracts/exchange2.sol#L4251-L4253)

contracts/exchange2.sol#L4244-L4268


 - [ ] ID-192
Low level call in [Address.functionCallWithValue(address,bytes,uint256)](contracts/exchange2.sol#L795-L801):
	- [(success,returndata) = target.call{value: value}(data)](contracts/exchange2.sol#L799)

contracts/exchange2.sol#L795-L801


## naming-convention
Impact: Informational
Confidence: High
 - [ ] ID-193
Constant [AccessControlUpgradeable.AccessControlStorageLocation](contracts/exchange2.sol#L496) is not in UPPER_CASE_WITH_UNDERSCORES

contracts/exchange2.sol#L496


 - [ ] ID-194
Parameter [ExchangeOverride.isTrustedForwarder(address)._forwarder](contracts/exchange2.sol#L4314) is not in mixedCase

contracts/exchange2.sol#L4314


 - [ ] ID-195
Function [AccessControlUpgradeable.__AccessControl_init_unchained()](contracts/exchange2.sol#L516-L517) is not in mixedCase

contracts/exchange2.sol#L516-L517


 - [ ] ID-196
Parameter [Exchange.withdraw(address,address,uint256,string,bool)._to](contracts/exchange2.sol#L4416) is not in mixedCase

contracts/exchange2.sol#L4416


 - [ ] ID-197
Parameter [Exchange.setLinkManual(address,address)._linkSemi](contracts/exchange2.sol#L4476) is not in mixedCase

contracts/exchange2.sol#L4476


 - [ ] ID-198
Parameter [Exchange.withdraw(address,address,uint256,string,bool)._fee](contracts/exchange2.sol#L4416) is not in mixedCase

contracts/exchange2.sol#L4416


 - [ ] ID-199
Parameter [Exchange.checkWithdraw(address,address,uint256,string,bool)._fee](contracts/exchange2.sol#L4406) is not in mixedCase

contracts/exchange2.sol#L4406


 - [ ] ID-200
Parameter [Exchange.withdraw(address,address,uint256,string,bool)._tokenName](contracts/exchange2.sol#L4416) is not in mixedCase

contracts/exchange2.sol#L4416


 - [ ] ID-201
Parameter [Exchange.comprar(string,string,uint256)._currency](contracts/exchange2.sol#L4487) is not in mixedCase

contracts/exchange2.sol#L4487


 - [ ] ID-202
Parameter [Exchange.withdraw(address,address,uint256,string,bool)._amount](contracts/exchange2.sol#L4416) is not in mixedCase

contracts/exchange2.sol#L4416


 - [ ] ID-203
Event [Exchange.bonusGiven(address,string,uint256,uint256)](contracts/exchange2.sol#L4385) is not in CapWords

contracts/exchange2.sol#L4385


 - [ ] ID-204
Parameter [Exchange.checkWithdraw(address,address,uint256,string,bool)._from](contracts/exchange2.sol#L4406) is not in mixedCase

contracts/exchange2.sol#L4406


 - [ ] ID-205
Parameter [Exchange.comprar(string,string,uint256)._amount](contracts/exchange2.sol#L4487) is not in mixedCase

contracts/exchange2.sol#L4487


 - [ ] ID-206
Function [EIP712._EIP712Version()](contracts/exchange2.sol#L4194-L4196) is not in mixedCase

contracts/exchange2.sol#L4194-L4196


 - [ ] ID-207
Parameter [Exchange.withdraw(address,address,uint256,string,bool)._from](contracts/exchange2.sol#L4416) is not in mixedCase

contracts/exchange2.sol#L4416


 - [ ] ID-208
Parameter [Exchange.setWithdrawFee(uint256,uint256,address)._withdrawFee](contracts/exchange2.sol#L4432) is not in mixedCase

contracts/exchange2.sol#L4432


 - [ ] ID-209
Parameter [Exchange.setSecurity(string,address,address,uint8,uint256)._securityName](contracts/exchange2.sol#L4453) is not in mixedCase

contracts/exchange2.sol#L4453


 - [ ] ID-210
Parameter [Exchange.setSecurity(string,address,address,uint8,uint256)._propiedad](contracts/exchange2.sol#L4453) is not in mixedCase

contracts/exchange2.sol#L4453


 - [ ] ID-211
Event [Exchange.whiteListed(address,address,uint256,address)](contracts/exchange2.sol#L4383) is not in CapWords

contracts/exchange2.sol#L4383


 - [ ] ID-212
Parameter [Exchange.checkWithdraw(address,address,uint256,string,bool)._to](contracts/exchange2.sol#L4406) is not in mixedCase

contracts/exchange2.sol#L4406


 - [ ] ID-213
Parameter [Exchange.setLink(address)._link](contracts/exchange2.sol#L4468) is not in mixedCase

contracts/exchange2.sol#L4468


 - [ ] ID-214
Parameter [Exchange.acceptWhitelist(address,uint256)._amount](contracts/exchange2.sol#L4446) is not in mixedCase

contracts/exchange2.sol#L4446


 - [ ] ID-215
Parameter [Exchange.setSecurity(string,address,address,uint8,uint256)._bonus](contracts/exchange2.sol#L4453) is not in mixedCase

contracts/exchange2.sol#L4453


 - [ ] ID-216
Parameter [ExchangeOverride.initialize(address)._forwarder](contracts/exchange2.sol#L4347) is not in mixedCase

contracts/exchange2.sol#L4347


 - [ ] ID-217
Function [ERC165Upgradeable.__ERC165_init_unchained()](contracts/exchange2.sol#L319-L320) is not in mixedCase

contracts/exchange2.sol#L319-L320


 - [ ] ID-218
Function [ContextUpgradeable.__Context_init_unchained()](contracts/exchange2.sol#L250-L251) is not in mixedCase

contracts/exchange2.sol#L250-L251


 - [ ] ID-219
Parameter [Exchange.checkWithdraw(address,address,uint256,string,bool)._tokenName](contracts/exchange2.sol#L4406) is not in mixedCase

contracts/exchange2.sol#L4406


 - [ ] ID-220
Function [UUPSUpgradeable.__UUPSUpgradeable_init_unchained()](contracts/exchange2.sol#L1275-L1276) is not in mixedCase

contracts/exchange2.sol#L1275-L1276


 - [ ] ID-221
Parameter [Exchange.link(address)._addr](contracts/exchange2.sol#L4439) is not in mixedCase

contracts/exchange2.sol#L4439


 - [ ] ID-222
Parameter [Exchange.setWithdrawWallets(address,address,uint8)._to](contracts/exchange2.sol#L4397) is not in mixedCase

contracts/exchange2.sol#L4397


 - [ ] ID-223
Parameter [Exchange.setWithdrawFee(uint256,uint256,address)._withdrawMinFee](contracts/exchange2.sol#L4432) is not in mixedCase

contracts/exchange2.sol#L4432


 - [ ] ID-224
Parameter [Exchange.setWithdrawWallets(address,address,uint8)._from](contracts/exchange2.sol#L4397) is not in mixedCase

contracts/exchange2.sol#L4397


 - [ ] ID-225
Function [AccessControlUpgradeable.__AccessControl_init()](contracts/exchange2.sol#L513-L514) is not in mixedCase

contracts/exchange2.sol#L513-L514


 - [ ] ID-226
Parameter [Exchange.acceptWhitelist(address,uint256)._addr](contracts/exchange2.sol#L4446) is not in mixedCase

contracts/exchange2.sol#L4446


 - [ ] ID-227
Parameter [Exchange.setCurrency(string,address,uint8)._addr](contracts/exchange2.sol#L4462) is not in mixedCase

contracts/exchange2.sol#L4462


 - [ ] ID-228
Parameter [Exchange.checkWithdraw(address,address,uint256,string,bool)._amount](contracts/exchange2.sol#L4406) is not in mixedCase

contracts/exchange2.sol#L4406


 - [ ] ID-229
Parameter [Exchange.setLinkManual(address,address)._link](contracts/exchange2.sol#L4476) is not in mixedCase

contracts/exchange2.sol#L4476


 - [ ] ID-230
Event [Exchange.withdrawFeeChanged(address,uint256,uint256,address,uint256)](contracts/exchange2.sol#L4387) is not in CapWords

contracts/exchange2.sol#L4387


 - [ ] ID-231
Variable [UUPSUpgradeable.__self](contracts/exchange2.sol#L1229) is not in mixedCase

contracts/exchange2.sol#L1229


 - [ ] ID-232
Parameter [Exchange.setCurrency(string,address,uint8)._currencyName](contracts/exchange2.sol#L4462) is not in mixedCase

contracts/exchange2.sol#L4462


 - [ ] ID-233
Function [UUPSUpgradeable.__UUPSUpgradeable_init()](contracts/exchange2.sol#L1272-L1273) is not in mixedCase

contracts/exchange2.sol#L1272-L1273


 - [ ] ID-234
Parameter [Exchange.setSecurity(string,address,address,uint8,uint256)._funds](contracts/exchange2.sol#L4453) is not in mixedCase

contracts/exchange2.sol#L4453


 - [ ] ID-235
Function [EIP712._EIP712Name()](contracts/exchange2.sol#L4183-L4185) is not in mixedCase

contracts/exchange2.sol#L4183-L4185


 - [ ] ID-236
Parameter [Exchange.setWithdrawFee(uint256,uint256,address)._feeAddress](contracts/exchange2.sol#L4432) is not in mixedCase

contracts/exchange2.sol#L4432


 - [ ] ID-237
Parameter [Exchange.setSecurity(string,address,address,uint8,uint256)._decimals](contracts/exchange2.sol#L4453) is not in mixedCase

contracts/exchange2.sol#L4453


 - [ ] ID-238
Function [PausableUpgradeable.__Pausable_init()](contracts/exchange2.sol#L1418-L1420) is not in mixedCase

contracts/exchange2.sol#L1418-L1420


 - [ ] ID-239
Event [Exchange.withdrawDone(address,address,address,uint256,uint256,string,bool,uint256)](contracts/exchange2.sol#L4386) is not in CapWords

contracts/exchange2.sol#L4386


 - [ ] ID-240
Parameter [Exchange.comprar(string,string,uint256)._security](contracts/exchange2.sol#L4487) is not in mixedCase

contracts/exchange2.sol#L4487


 - [ ] ID-241
Function [ContextUpgradeable.__Context_init()](contracts/exchange2.sol#L247-L248) is not in mixedCase

contracts/exchange2.sol#L247-L248


 - [ ] ID-242
Parameter [Exchange.setCurrency(string,address,uint8)._decimals](contracts/exchange2.sol#L4462) is not in mixedCase

contracts/exchange2.sol#L4462


 - [ ] ID-243
Function [ERC165Upgradeable.__ERC165_init()](contracts/exchange2.sol#L316-L317) is not in mixedCase

contracts/exchange2.sol#L316-L317


 - [ ] ID-244
Parameter [Exchange.setWithdrawWallets(address,address,uint8)._value](contracts/exchange2.sol#L4397) is not in mixedCase

contracts/exchange2.sol#L4397


 - [ ] ID-245
Constant [PausableUpgradeable.PausableStorageLocation](contracts/exchange2.sol#L1387) is not in UPPER_CASE_WITH_UNDERSCORES

contracts/exchange2.sol#L1387


 - [ ] ID-246
Function [PausableUpgradeable.__Pausable_init_unchained()](contracts/exchange2.sol#L1422-L1425) is not in mixedCase

contracts/exchange2.sol#L1422-L1425


## too-many-digits
Impact: Informational
Confidence: Medium
 - [ ] ID-247
[Exchange.comprar(string,string,uint256)](contracts/exchange2.sol#L4487-L4526) uses literals with too many digits:
	- [require(bool)(_amount > 1000000)](contracts/exchange2.sol#L4488)

contracts/exchange2.sol#L4487-L4526


 - [ ] ID-248
[ShortStrings.slitherConstructorConstantVariables()](contracts/exchange2.sol#L3955-L4038) uses literals with too many digits:
	- [FALLBACK_SENTINEL = 0x00000000000000000000000000000000000000000000000000000000000000FF](contracts/exchange2.sol#L3957)

contracts/exchange2.sol#L3955-L4038


## unused-state
Impact: Informational
Confidence: High
 - [ ] ID-249
[Panic.GENERIC](contracts/exchange2.sol#L2991) is never used in [Panic](contracts/exchange2.sol#L2989-L3021)

contracts/exchange2.sol#L2991


 - [ ] ID-250
[Panic.ENUM_CONVERSION_ERROR](contracts/exchange2.sol#L2999) is never used in [Panic](contracts/exchange2.sol#L2989-L3021)

contracts/exchange2.sol#L2999


 - [ ] ID-251
[Panic.EMPTY_ARRAY_POP](contracts/exchange2.sol#L3003) is never used in [Panic](contracts/exchange2.sol#L2989-L3021)

contracts/exchange2.sol#L3003


 - [ ] ID-252
[Panic.UNDER_OVERFLOW](contracts/exchange2.sol#L2995) is never used in [Panic](contracts/exchange2.sol#L2989-L3021)

contracts/exchange2.sol#L2995


 - [ ] ID-253
[Panic.INVALID_INTERNAL_FUNCTION](contracts/exchange2.sol#L3009) is never used in [Panic](contracts/exchange2.sol#L2989-L3021)

contracts/exchange2.sol#L3009


 - [ ] ID-254
[Panic.ASSERT](contracts/exchange2.sol#L2993) is never used in [Panic](contracts/exchange2.sol#L2989-L3021)

contracts/exchange2.sol#L2993


 - [ ] ID-255
[Panic.ARRAY_OUT_OF_BOUNDS](contracts/exchange2.sol#L3005) is never used in [Panic](contracts/exchange2.sol#L2989-L3021)

contracts/exchange2.sol#L3005


 - [ ] ID-256
[Panic.RESOURCE_ERROR](contracts/exchange2.sol#L3007) is never used in [Panic](contracts/exchange2.sol#L2989-L3021)

contracts/exchange2.sol#L3007


 - [ ] ID-257
[Panic.STORAGE_ENCODING_ERROR](contracts/exchange2.sol#L3001) is never used in [Panic](contracts/exchange2.sol#L2989-L3021)

contracts/exchange2.sol#L3001


 - [ ] ID-258
[Panic.DIVISION_BY_ZERO](contracts/exchange2.sol#L2997) is never used in [Panic](contracts/exchange2.sol#L2989-L3021)

contracts/exchange2.sol#L2997


