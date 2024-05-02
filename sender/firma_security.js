const fetch = require('isomorphic-fetch');
const { Web3 } = require('web3'); // para poder leer el nonce del forwarder y para generar abiEncode de la función a llamar. es de solo lectura en la blockchain
const ethSigUtil = require('eth-sig-util'); // utilizado para firmar ya que con web3js no funcionaron las firmas al relayer
var web3 = new Web3('https://rpc-amoy.polygon.technology/'); // un nodo abierto ya que solo lo usamos para lectura
require('dotenv').config();

const chainId = 80002; // 80002 para amoy
const ForwarderAbi  = [ { "inputs": [], "stateMutability": "nonpayable", "type": "constructor" }, { "inputs": [], "name": "ECDSAInvalidSignature", "type": "error" }, { "inputs": [ { "internalType": "uint256", "name": "length", "type": "uint256" } ], "name": "ECDSAInvalidSignatureLength", "type": "error" }, { "inputs": [ { "internalType": "bytes32", "name": "s", "type": "bytes32" } ], "name": "ECDSAInvalidSignatureS", "type": "error" }, { "inputs": [], "name": "InvalidShortString", "type": "error" }, { "inputs": [ { "internalType": "string", "name": "str", "type": "string" } ], "name": "StringTooLong", "type": "error" }, { "anonymous": false, "inputs": [], "name": "EIP712DomainChanged", "type": "event" }, { "stateMutability": "payable", "type": "fallback" }, { "inputs": [], "name": "_signer", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "eip712Domain", "outputs": [ { "internalType": "bytes1", "name": "fields", "type": "bytes1" }, { "internalType": "string", "name": "name", "type": "string" }, { "internalType": "string", "name": "version", "type": "string" }, { "internalType": "uint256", "name": "chainId", "type": "uint256" }, { "internalType": "address", "name": "verifyingContract", "type": "address" }, { "internalType": "bytes32", "name": "salt", "type": "bytes32" }, { "internalType": "uint256[]", "name": "extensions", "type": "uint256[]" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "components": [ { "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "value", "type": "uint256" }, { "internalType": "uint256", "name": "gas", "type": "uint256" }, { "internalType": "uint256", "name": "nonce", "type": "uint256" }, { "internalType": "bytes", "name": "data", "type": "bytes" } ], "internalType": "struct MinimalForwarder.ForwardRequest", "name": "req", "type": "tuple" }, { "internalType": "bytes", "name": "signature", "type": "bytes" } ], "name": "execute", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" }, { "internalType": "bytes", "name": "", "type": "bytes" } ], "stateMutability": "payable", "type": "function" }, { "inputs": [ { "internalType": "address", "name": "from", "type": "address" } ], "name": "getNonce", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "stateMutability": "view", "type": "function" }, { "inputs": [ { "components": [ { "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "value", "type": "uint256" }, { "internalType": "uint256", "name": "gas", "type": "uint256" }, { "internalType": "uint256", "name": "nonce", "type": "uint256" }, { "internalType": "bytes", "name": "data", "type": "bytes" } ], "internalType": "struct MinimalForwarder.ForwardRequest", "name": "req", "type": "tuple" }, { "internalType": "bytes", "name": "signature", "type": "bytes" } ], "name": "verify", "outputs": [ { "internalType": "bool", "name": "", "type": "bool" } ], "stateMutability": "nonpayable", "type": "function" }, { "stateMutability": "payable", "type": "receive" } ];
const ForwarderAddress = process.env.CONTRATO_FORWARDER;
const calleeAbi = [{"inputs": [],"stateMutability": "nonpayable","type": "constructor"},{"inputs": [],"name": "AccessControlBadConfirmation","type": "error"},{"inputs": [{"internalType": "address","name": "account","type": "address"},{"internalType": "bytes32","name": "neededRole","type": "bytes32"}],"name": "AccessControlUnauthorizedAccount","type": "error"},{"inputs": [{"internalType": "address","name": "target","type": "address"}],"name": "AddressEmptyCode","type": "error"},{"inputs": [],"name": "ECDSAInvalidSignature","type": "error"},{"inputs": [{"internalType": "uint256","name": "length","type": "uint256"}],"name": "ECDSAInvalidSignatureLength","type": "error"},{"inputs": [{"internalType": "bytes32","name": "s","type": "bytes32"}],"name": "ECDSAInvalidSignatureS","type": "error"},{"inputs": [{"internalType": "address","name": "implementation","type": "address"}],"name": "ERC1967InvalidImplementation","type": "error"},{"inputs": [],"name": "ERC1967NonPayable","type": "error"},{"inputs": [],"name": "EnforcedPause","type": "error"},{"inputs": [],"name": "ExpectedPause","type": "error"},{"inputs": [],"name": "FailedInnerCall","type": "error"},{"inputs": [],"name": "InvalidInitialization","type": "error"},{"inputs": [],"name": "InvalidShortString","type": "error"},{"inputs": [],"name": "NotInitializing","type": "error"},{"inputs": [{"internalType": "string","name": "str","type": "string"}],"name": "StringTooLong","type": "error"},{"inputs": [],"name": "UUPSUnauthorizedCallContext","type": "error"},{"inputs": [{"internalType": "bytes32","name": "slot","type": "bytes32"}],"name": "UUPSUnsupportedProxiableUUID","type": "error"},{"anonymous": false,"inputs": [{"indexed": true,"internalType": "address","name": "whoAdded","type": "address"},{"indexed": true,"internalType": "address","name": "currency","type": "address"},{"indexed": true,"internalType": "uint256","name": "timestamp","type": "uint256"},{"indexed": false,"internalType": "string","name": "curName","type": "string"}],"name": "CurrencyAdded","type": "event"},{"anonymous": false,"inputs": [],"name": "EIP712DomainChanged","type": "event"},{"anonymous": false,"inputs": [{"indexed": false,"internalType": "uint64","name": "version","type": "uint64"}],"name": "Initialized","type": "event"},{"anonymous": false,"inputs": [{"indexed": false,"internalType": "address","name": "account","type": "address"}],"name": "Paused","type": "event"},{"anonymous": false,"inputs": [{"indexed": true,"internalType": "address","name": "whoAdded","type": "address"},{"indexed": true,"internalType": "address","name": "security","type": "address"},{"indexed": true,"internalType": "uint256","name": "timestamp","type": "uint256"},{"indexed": false,"internalType": "string","name": "curName","type": "string"},{"indexed": false,"internalType": "address","name": "funds","type": "address"}],"name": "ProjectAdded","type": "event"},{"anonymous": false,"inputs": [{"indexed": true,"internalType": "bytes32","name": "role","type": "bytes32"},{"indexed": true,"internalType": "bytes32","name": "previousAdminRole","type": "bytes32"},{"indexed": true,"internalType": "bytes32","name": "newAdminRole","type": "bytes32"}],"name": "RoleAdminChanged","type": "event"},{"anonymous": false,"inputs": [{"indexed": true,"internalType": "bytes32","name": "role","type": "bytes32"},{"indexed": true,"internalType": "address","name": "account","type": "address"},{"indexed": true,"internalType": "address","name": "sender","type": "address"}],"name": "RoleGranted","type": "event"},{"anonymous": false,"inputs": [{"indexed": true,"internalType": "bytes32","name": "role","type": "bytes32"},{"indexed": true,"internalType": "address","name": "account","type": "address"},{"indexed": true,"internalType": "address","name": "sender","type": "address"}],"name": "RoleRevoked","type": "event"},{"anonymous": false,"inputs": [{"indexed": true,"internalType": "address","name": "curSender","type": "address"},{"indexed": true,"internalType": "address","name": "secReceiver","type": "address"},{"indexed": true,"internalType": "uint256","name": "timestamp","type": "uint256"},{"indexed": false,"internalType": "uint256","name": "quantity","type": "uint256"}],"name": "Trade","type": "event"},{"anonymous": false,"inputs": [{"indexed": false,"internalType": "address","name": "account","type": "address"}],"name": "Unpaused","type": "event"},{"anonymous": false,"inputs": [{"indexed": true,"internalType": "address","name": "implementation","type": "address"}],"name": "Upgraded","type": "event"},{"anonymous": false,"inputs": [{"indexed": true,"internalType": "address","name": "curAddr","type": "address"},{"indexed": true,"internalType": "address","name": "secAddr","type": "address"},{"indexed": true,"internalType": "uint256","name": "timestamp","type": "uint256"},{"indexed": false,"internalType": "address","name": "whoAdded","type": "address"}],"name": "whiteListed","type": "event"},{"inputs": [],"name": "DEFAULT_ADMIN_ROLE","outputs": [{"internalType": "bytes32","name": "","type": "bytes32"}],"stateMutability": "view","type": "function"},{"inputs": [],"name": "EXCHANGER_ROLE","outputs": [{"internalType": "bytes32","name": "","type": "bytes32"}],"stateMutability": "view","type": "function"},{"inputs": [],"name": "PAUSER_ROLE","outputs": [{"internalType": "bytes32","name": "","type": "bytes32"}],"stateMutability": "view","type": "function"},{"inputs": [],"name": "PROJECTCREATOR_ROLE","outputs": [{"internalType": "bytes32","name": "","type": "bytes32"}],"stateMutability": "view","type": "function"},{"inputs": [],"name": "UPGRADER_ROLE","outputs": [{"internalType": "bytes32","name": "","type": "bytes32"}],"stateMutability": "view","type": "function"},{"inputs": [],"name": "UPGRADE_INTERFACE_VERSION","outputs": [{"internalType": "string","name": "","type": "string"}],"stateMutability": "view","type": "function"},{"inputs": [],"name": "WHITELISTER_ROLE","outputs": [{"internalType": "bytes32","name": "","type": "bytes32"}],"stateMutability": "view","type": "function"},{"inputs": [{"internalType": "address","name": "_addr","type": "address"}],"name": "acceptWhitelist","outputs": [],"stateMutability": "nonpayable","type": "function"},{"inputs": [{"internalType": "string","name": "_currency","type": "string"},{"internalType": "string","name": "_security","type": "string"},{"internalType": "uint256","name": "_amount","type": "uint256"}],"name": "comprar","outputs": [{"internalType": "bool","name": "_success","type": "bool"}],"stateMutability": "nonpayable","type": "function"},{"inputs": [{"internalType": "string","name": "","type": "string"}],"name": "crowdfounding","outputs": [{"internalType": "address","name": "","type": "address"}],"stateMutability": "view","type": "function"},{"inputs": [{"internalType": "string","name": "","type": "string"}],"name": "currency","outputs": [{"internalType": "contract IERC20","name": "","type": "address"}],"stateMutability": "view","type": "function"},{"inputs": [],"name": "eip712Domain","outputs": [{"internalType": "bytes1","name": "fields","type": "bytes1"},{"internalType": "string","name": "name","type": "string"},{"internalType": "string","name": "version","type": "string"},{"internalType": "uint256","name": "chainId","type": "uint256"},{"internalType": "address","name": "verifyingContract","type": "address"},{"internalType": "bytes32","name": "salt","type": "bytes32"},{"internalType": "uint256[]","name": "extensions","type": "uint256[]"}],"stateMutability": "view","type": "function"},{"inputs": [{"components": [{"internalType": "address","name": "from","type": "address"},{"internalType": "address","name": "to","type": "address"},{"internalType": "uint256","name": "value","type": "uint256"},{"internalType": "uint256","name": "gas","type": "uint256"},{"internalType": "uint256","name": "nonce","type": "uint256"},{"internalType": "bytes","name": "data","type": "bytes"}],"internalType": "struct MinimalForwarder.ForwardRequest","name": "req","type": "tuple"},{"internalType": "bytes","name": "signature","type": "bytes"}],"name": "execute","outputs": [{"internalType": "bool","name": "","type": "bool"},{"internalType": "bytes","name": "","type": "bytes"}],"stateMutability": "payable","type": "function"},{"inputs": [{"internalType": "address","name": "from","type": "address"}],"name": "getNonce","outputs": [{"internalType": "uint256","name": "","type": "uint256"}],"stateMutability": "view","type": "function"},{"inputs": [{"internalType": "bytes32","name": "role","type": "bytes32"}],"name": "getRoleAdmin","outputs": [{"internalType": "bytes32","name": "","type": "bytes32"}],"stateMutability": "view","type": "function"},{"inputs": [{"internalType": "bytes32","name": "role","type": "bytes32"},{"internalType": "address","name": "account","type": "address"}],"name": "grantRole","outputs": [],"stateMutability": "nonpayable","type": "function"},{"inputs": [{"internalType": "bytes32","name": "role","type": "bytes32"},{"internalType": "address","name": "account","type": "address"}],"name": "hasRole","outputs": [{"internalType": "bool","name": "","type": "bool"}],"stateMutability": "view","type": "function"},{"inputs": [{"internalType": "address","name": "trustedForwarder_","type": "address"}],"name": "initialize","outputs": [],"stateMutability": "nonpayable","type": "function"},{"inputs": [{"internalType": "address","name": "forwarder","type": "address"}],"name": "isTrustedForwarder","outputs": [{"internalType": "bool","name": "","type": "bool"}],"stateMutability": "view","type": "function"},{"inputs": [{"internalType": "address","name": "_addr","type": "address"}],"name": "link","outputs": [{"internalType": "address","name": "","type": "address"}],"stateMutability": "view","type": "function"},{"inputs": [],"name": "pause","outputs": [],"stateMutability": "nonpayable","type": "function"},{"inputs": [],"name": "paused","outputs": [{"internalType": "bool","name": "","type": "bool"}],"stateMutability": "view","type": "function"},{"inputs": [],"name": "proxiableUUID","outputs": [{"internalType": "bytes32","name": "","type": "bytes32"}],"stateMutability": "view","type": "function"},{"inputs": [{"internalType": "bytes32","name": "role","type": "bytes32"},{"internalType": "address","name": "callerConfirmation","type": "address"}],"name": "renounceRole","outputs": [],"stateMutability": "nonpayable","type": "function"},{"inputs": [{"internalType": "bytes32","name": "role","type": "bytes32"},{"internalType": "address","name": "account","type": "address"}],"name": "revokeRole","outputs": [],"stateMutability": "nonpayable","type": "function"},{"inputs": [{"internalType": "string","name": "","type": "string"}],"name": "security","outputs": [{"internalType": "contract IERC20","name": "","type": "address"}],"stateMutability": "view","type": "function"},{"inputs": [{"internalType": "string","name": "_name","type": "string"},{"internalType": "address","name": "_addr","type": "address"},{"internalType": "uint8","name": "_decimals","type": "uint8"}],"name": "setCurrency","outputs": [],"stateMutability": "nonpayable","type": "function"},{"inputs": [{"internalType": "address","name": "_link","type": "address"}],"name": "setLink","outputs": [],"stateMutability": "nonpayable","type": "function"},{"inputs": [{"internalType": "address","name": "_link","type": "address"},{"internalType": "address","name": "_linksemi","type": "address"}],"name": "setLinkManual","outputs": [],"stateMutability": "nonpayable","type": "function"},{"inputs": [{"internalType": "string","name": "_name","type": "string"},{"internalType": "address","name": "_propiedad","type": "address"},{"internalType": "address","name": "_funds","type": "address"},{"internalType": "uint8","name": "_decimals","type": "uint8"}],"name": "setSecurity","outputs": [],"stateMutability": "nonpayable","type": "function"},{"inputs": [{"internalType": "bytes4","name": "interfaceId","type": "bytes4"}],"name": "supportsInterface","outputs": [{"internalType": "bool","name": "","type": "bool"}],"stateMutability": "view","type": "function"},{"inputs": [],"name": "trustedForwarder","outputs": [{"internalType": "address","name": "","type": "address"}],"stateMutability": "view","type": "function"},{"inputs": [],"name": "unpause","outputs": [],"stateMutability": "nonpayable","type": "function"},{"inputs": [{"internalType": "address","name": "newImplementation","type": "address"},{"internalType": "bytes","name": "data","type": "bytes"}],"name": "upgradeToAndCall","outputs": [],"stateMutability": "payable","type": "function"},{"inputs": [{"components": [{"internalType": "address","name": "from","type": "address"},{"internalType": "address","name": "to","type": "address"},{"internalType": "uint256","name": "value","type": "uint256"},{"internalType": "uint256","name": "gas","type": "uint256"},{"internalType": "uint256","name": "nonce","type": "uint256"},{"internalType": "bytes","name": "data","type": "bytes"}],"internalType": "struct MinimalForwarder.ForwardRequest","name": "req","type": "tuple"},{"internalType": "bytes","name": "signature","type": "bytes"}],"name": "verify","outputs": [{"internalType": "bool","name": "","type": "bool"}],"stateMutability": "view","type": "function"},{"inputs": [{"internalType": "address","name": "","type": "address"}],"name": "whitelist","outputs": [{"internalType": "bool","name": "","type": "bool"}],"stateMutability": "view","type": "function"}];
const calleeAddress = process.env.SECURITY_ADDRESS;
callee_contract = new web3.eth.Contract(calleeAbi,calleeAddress);  // contrato al que quiero llamar sin pagar gas, arriba las abi y el address (venta de token)
forwarder_contract= new web3.eth.Contract(ForwarderAbi,ForwarderAddress); // Contrato que redirige las llamadas, arriba las abi y el address


const callerPrivKey = process.env.CALLER_PRIV_KEY; // Agregar la clave privada de la wallet que firma la transaccion
const callerAddress = process.env.CALLER_ADDRESS; // Agregar el address de quien firma



//////////////////////////////////////////// Desde acá viene la lógica para que funcione la firma para el relayer //////////////////////////////////////

const EIP712Domain = [
    { name: 'name', type: 'string' },
    { name: 'version', type: 'string' },
    { name: 'chainId', type: 'uint256' },
    { name: 'verifyingContract', type: 'address' }
  ];
  
  const ForwardRequest = [
    { name: 'from', type: 'address' },
    { name: 'to', type: 'address' },
    { name: 'value', type: 'uint256' },
    { name: 'gas', type: 'uint256' },
    { name: 'nonce', type: 'uint256' },
    { name: 'data', type: 'bytes' },
  ];
  
  function getMetaTxTypeData(chainId, verifyingContract) {
    return {
      types: {
        EIP712Domain,
        ForwardRequest,
      },
      domain: {
        name: 'MinimalForwarder',
        version: '0.0.1',
        chainId,
        verifyingContract,
      },
      primaryType: 'ForwardRequest',
    }
  };
  
  async function signTypedData(signer, from, data) {
      const privateKey = Buffer.from(signer.replace(/^0x/, ''), 'hex');
      return ethSigUtil.signTypedMessage(privateKey, { data });
  }
  
  async function buildRequest(forwarder, input) {
    var nonce= await forwarder_contract.methods.getNonce(input.from).call().then((_nonce)=>{return(_nonce.toString())});
    console.log(nonce);
    return { value: 0, gas: 3e5, nonce, ...input };
  }
  
  async function buildTypedData(forwarder, request) {
    const typeData = getMetaTxTypeData(chainId, forwarder);
    return { ...typeData, message: request };
  }
  
  async function signMetaTxRequest(signer, forwarder, input) {
    const request = await buildRequest(forwarder, input);
    const toSign = await buildTypedData(forwarder, request);
    const signature = await signTypedData(signer, input.from, toSign);
    return { signature, request };
  }
  
  

/*
        address from;
        address to;
        uint256 value;
        uint256 gas;
        uint256 nonce;
        bytes data;
*/
async function sendRelayer(data) {
    var request = {
      to: calleeAddress,
      from: callerAddress,
      data,
    };
    request = await signMetaTxRequest(callerPrivKey, ForwarderAddress, request); 
    console.log(request);
    //request.request.from = request.request.to;
    const response = await backendEndpoint(request);
/*
    const sortedData = {
        request: {
            from: request.request.from,
            to: request.request.to,
            value: request.request.value,
            gas: request.request.gas,
            nonce: request.request.nonce,
            data: request.request.data
        },
        signature: request.signature
      };

      console.log(sortedData);

      let resultado = await forwarder_contract.methods.execute(sortedData.request, sortedData.signature).call(); // Esta es la función que debo modificar para llamar distintas funciones
      console.log(resultado);
*/
}
/////////////////////////////////////////////////////////////////////////////////////////////////



async function backendEndpoint(request) {
  //return request;
  const url='http://localhost/relayer/receiver/';
  const createReceipt = await fetch(url, {
        method: 'POST',
        body: JSON.stringify(request),
        headers: { 'Content-Type': 'application/json' },
  });
  const responseText = await createReceipt.text(); // Obtener la respuesta como texto
  console.log(`Transaction successful with hash: ${JSON.stringify(responseText)}`);
}



/*
Unica función a modificar para llamar a distintas funciones utilizando el relayer.
*/
async function main() { 
    //const data = await callee_contract.methods.whiteListSelf("0xD76b9E2Ff8625F40E225B25041cf5c8C800e1953",5000000000).encodeABI(); // Esta es la función que debo modificar para llamar distintas funciones. El address es la de la persona a quien se le mintea los tokens
    //console.log(data);
    const data = "0x9e799e58000000000000000000000000D76b9E2Ff8625F40E225B25041cf5c8C800e1953000000000000000000000000000000000000000000000000000000e8d4a51000"; // para hacer whitelisting en security token

    sendRelayer(data);
  }
  
  main();





