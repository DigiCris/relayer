const fetch = require('isomorphic-fetch');
const { Web3 } = require('web3'); // para poder leer el nonce del forwarder y para generar abiEncode de la función a llamar. es de solo lectura en la blockchain
const ethSigUtil = require('eth-sig-util'); // utilizado para firmar ya que con web3js no funcionaron las firmas al relayer
var web3 = new Web3('https://rpc-amoy.polygon.technology/'); // un nodo abierto ya que solo lo usamos para lectura
require('dotenv').config();

const chainId = 80002; // 80001 para mumbai
const ForwarderAbi = [{ "inputs": [], "stateMutability": "nonpayable", "type": "constructor" }, { "inputs": [], "name": "ECDSAInvalidSignature", "type": "error" }, { "inputs": [{ "internalType": "uint256", "name": "length", "type": "uint256" }], "name": "ECDSAInvalidSignatureLength", "type": "error" }, { "inputs": [{ "internalType": "bytes32", "name": "s", "type": "bytes32" }], "name": "ECDSAInvalidSignatureS", "type": "error" }, { "inputs": [], "name": "InvalidShortString", "type": "error" }, { "inputs": [{ "internalType": "string", "name": "str", "type": "string" }], "name": "StringTooLong", "type": "error" }, { "anonymous": false, "inputs": [], "name": "EIP712DomainChanged", "type": "event" }, { "stateMutability": "payable", "type": "fallback" }, { "inputs": [], "name": "_signer", "outputs": [{ "internalType": "address", "name": "", "type": "address" }], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "eip712Domain", "outputs": [{ "internalType": "bytes1", "name": "fields", "type": "bytes1" }, { "internalType": "string", "name": "name", "type": "string" }, { "internalType": "string", "name": "version", "type": "string" }, { "internalType": "uint256", "name": "chainId", "type": "uint256" }, { "internalType": "address", "name": "verifyingContract", "type": "address" }, { "internalType": "bytes32", "name": "salt", "type": "bytes32" }, { "internalType": "uint256[]", "name": "extensions", "type": "uint256[]" }], "stateMutability": "view", "type": "function" }, { "inputs": [{ "components": [{ "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "value", "type": "uint256" }, { "internalType": "uint256", "name": "gas", "type": "uint256" }, { "internalType": "uint256", "name": "nonce", "type": "uint256" }, { "internalType": "bytes", "name": "data", "type": "bytes" }], "internalType": "struct MinimalForwarder.ForwardRequest", "name": "req", "type": "tuple" }, { "internalType": "bytes", "name": "signature", "type": "bytes" }], "name": "execute", "outputs": [{ "internalType": "bool", "name": "", "type": "bool" }, { "internalType": "bytes", "name": "", "type": "bytes" }], "stateMutability": "payable", "type": "function" }, { "inputs": [{ "internalType": "address", "name": "from", "type": "address" }], "name": "getNonce", "outputs": [{ "internalType": "uint256", "name": "", "type": "uint256" }], "stateMutability": "view", "type": "function" }, { "inputs": [{ "components": [{ "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "value", "type": "uint256" }, { "internalType": "uint256", "name": "gas", "type": "uint256" }, { "internalType": "uint256", "name": "nonce", "type": "uint256" }, { "internalType": "bytes", "name": "data", "type": "bytes" }], "internalType": "struct MinimalForwarder.ForwardRequest", "name": "req", "type": "tuple" }, { "internalType": "bytes", "name": "signature", "type": "bytes" }], "name": "verify", "outputs": [{ "internalType": "bool", "name": "", "type": "bool" }], "stateMutability": "nonpayable", "type": "function" }, { "stateMutability": "payable", "type": "receive" }];
const ForwarderAddress = '0x0f56EA91233eA958eA3820Ba0F94349aFD866833';
const calleeAbi = [{ "inputs": [{ "internalType": "contract MinimalForwarder", "name": "forwarder", "type": "address" }], "stateMutability": "payable", "type": "constructor" }, { "inputs": [], "name": "ECDSAInvalidSignature", "type": "error" }, { "inputs": [{ "internalType": "uint256", "name": "length", "type": "uint256" }], "name": "ECDSAInvalidSignatureLength", "type": "error" }, { "inputs": [{ "internalType": "bytes32", "name": "s", "type": "bytes32" }], "name": "ECDSAInvalidSignatureS", "type": "error" }, { "inputs": [], "name": "InvalidShortString", "type": "error" }, { "inputs": [{ "internalType": "string", "name": "str", "type": "string" }], "name": "StringTooLong", "type": "error" }, { "anonymous": false, "inputs": [], "name": "EIP712DomainChanged", "type": "event" }, { "stateMutability": "payable", "type": "fallback" }, { "inputs": [], "name": "_signer", "outputs": [{ "internalType": "address", "name": "", "type": "address" }], "stateMutability": "view", "type": "function" }, { "inputs": [{ "internalType": "address", "name": "", "type": "address" }], "name": "balance", "outputs": [{ "internalType": "uint256", "name": "", "type": "uint256" }], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "eip712Domain", "outputs": [{ "internalType": "bytes1", "name": "fields", "type": "bytes1" }, { "internalType": "string", "name": "name", "type": "string" }, { "internalType": "string", "name": "version", "type": "string" }, { "internalType": "uint256", "name": "chainId", "type": "uint256" }, { "internalType": "address", "name": "verifyingContract", "type": "address" }, { "internalType": "bytes32", "name": "salt", "type": "bytes32" }, { "internalType": "uint256[]", "name": "extensions", "type": "uint256[]" }], "stateMutability": "view", "type": "function" }, { "inputs": [{ "components": [{ "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "value", "type": "uint256" }, { "internalType": "uint256", "name": "gas", "type": "uint256" }, { "internalType": "uint256", "name": "nonce", "type": "uint256" }, { "internalType": "bytes", "name": "data", "type": "bytes" }], "internalType": "struct MinimalForwarder.ForwardRequest", "name": "req", "type": "tuple" }, { "internalType": "bytes", "name": "signature", "type": "bytes" }], "name": "execute", "outputs": [{ "internalType": "bool", "name": "", "type": "bool" }, { "internalType": "bytes", "name": "", "type": "bytes" }], "stateMutability": "payable", "type": "function" }, { "inputs": [{ "internalType": "address", "name": "from", "type": "address" }], "name": "getNonce", "outputs": [{ "internalType": "uint256", "name": "", "type": "uint256" }], "stateMutability": "view", "type": "function" }, { "inputs": [{ "internalType": "address", "name": "forwarder", "type": "address" }], "name": "isTrustedForwarder", "outputs": [{ "internalType": "bool", "name": "", "type": "bool" }], "stateMutability": "view", "type": "function" }, { "inputs": [], "name": "owner", "outputs": [{ "internalType": "address", "name": "", "type": "address" }], "stateMutability": "view", "type": "function" }, { "inputs": [{ "internalType": "address", "name": "_addr", "type": "address" }], "name": "setBalance", "outputs": [], "stateMutability": "nonpayable", "type": "function" }, { "inputs": [], "name": "trustedForwarder", "outputs": [{ "internalType": "address", "name": "", "type": "address" }], "stateMutability": "view", "type": "function" }, { "inputs": [{ "components": [{ "internalType": "address", "name": "from", "type": "address" }, { "internalType": "address", "name": "to", "type": "address" }, { "internalType": "uint256", "name": "value", "type": "uint256" }, { "internalType": "uint256", "name": "gas", "type": "uint256" }, { "internalType": "uint256", "name": "nonce", "type": "uint256" }, { "internalType": "bytes", "name": "data", "type": "bytes" }], "internalType": "struct MinimalForwarder.ForwardRequest", "name": "req", "type": "tuple" }, { "internalType": "bytes", "name": "signature", "type": "bytes" }], "name": "verify", "outputs": [{ "internalType": "bool", "name": "", "type": "bool" }], "stateMutability": "nonpayable", "type": "function" }, { "stateMutability": "payable", "type": "receive" }];
const calleeAddress = '0x6867ff657d1d7BC23f0A5810d835e5C6f4e0B583';
callee_contract = new web3.eth.Contract(calleeAbi, calleeAddress);  // contrato al que quiero llamar sin pagar gas, arriba las abi y el address (venta de token)
forwarder_contract = new web3.eth.Contract(ForwarderAbi, ForwarderAddress); // Contrato que redirige las llamadas, arriba las abi y el address


const callerPrivKey = process.env.CALLER_PRIV_KEY; // Agregar la clave privada de la wallet que firma la transaccion
const callerAddress = process.env.CALLER_ADDRESS; // Agregar el address de quien firma


//[0x112D7B19A01fa18CbdaA069D266553BE254bfF90,0x6867ff657d1d7BC23f0A5810d835e5C6f4e0B583,0,1000000,0,0x9eda069f000000000000000000000000250a6e217023b648b7d42a6e7f99bb380e104326]
//"0xcbe6d6e13b271bdb321c733d925abf10002bea4062098cd18da0cabef19cdb3b0f889c8b7dc2f0d41cfcfa695cf63cfacdf23a665be335d3bec0bf78aaee7cbe1c"


//0x112D7B19A01fa18CbdaA069D266553BE254bfF90,0x6867ff657d1d7BC23f0A5810d835e5C6f4e0B583,0,1000000,0,0x9eda069f000000000000000000000000250a6e217023b648b7d42a6e7f99bb380e104326,0x8f3030420e2376d7f80e8d70a49abfdb72bd48eeb5d5a13c…59d2629854ed7fbcb4504c303ab0bba35fdf7fd61c0b1f21c

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
  var nonce = await forwarder_contract.methods.getNonce(input.from).call().then((_nonce) => { return (_nonce.toString()) });
  console.log(nonce);
  return { value: 0, gas: 1e5, nonce, ...input };
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
  const url = 'http://localhost/relayer/receiver/';
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
  const data = await callee_contract.methods.setBalance('0x250a6e217023b648b7D42A6e7F99bb380E104326').encodeABI(); // Esta es la función que debo modificar para llamar distintas funciones. El address es la de la persona a quien se le mintea los tokens
  //console.log(data);
  sendRelayer(data);
}

main();





