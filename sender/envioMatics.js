const Web3 = require('web3');
const web3 = new Web3('https://matic-testnet-archive-rpc.bwarelabs.com');

// Direcciones inventadas de las billeteras
const senderAddress = '0x1234567890123456789012345678901234567890';
const receiverAddress1 = '0x0987654321098765432109876543210987654321';
const receiverAddress2 = '0xabcdefabcdefabcdefabcdefabcdefabcdefabcd';

// Cantidad de Matic a enviar a cada dirección
const amountToSend = web3.utils.toWei('100', 'ether'); // Ejemplo: enviar 100 Matic

// Función para enviar Matic masivamente a las billeteras de destino
async function sendMassiveTransactions() {
  const privateKey = '0x...'; // Inserta aquí la clave privada de tu billetera

  const senderNonce = await web3.eth.getTransactionCount(senderAddress);
  const gasPrice = await web3.eth.getGasPrice();
  const gasLimit = 21000; // Gas limit para una transferencia básica

  // Crear una lista de objetos de transacción para cada dirección de destino
  const transactions = [
    {
      to: receiverAddress1,
      nonce: senderNonce,
      value: amountToSend,
      gasPrice: gasPrice,
      gas: gasLimit,
    },
    {
      to: receiverAddress2,
      nonce: senderNonce + 1,
      value: amountToSend,
      gasPrice: gasPrice,
      gas: gasLimit,
    },
    // Agrega más objetos de transacción para las otras direcciones de destino
  ];

  // Firmar todas las transacciones masivamente
  const signedTransactions = await Promise.all(
    transactions.map(async (transaction) => {
      const signedTx = await web3.eth.accounts.signTransaction(transaction, privateKey);
      return signedTx.rawTransaction;
    })
  );

  // Enviar todas las transacciones masivamente a la red de Matic (Polygon)
  const transactionReceipts = await web3.eth.sendSignedTransaction(signedTransactions);

  // Imprimir los hashes de transacción para cada transacción enviada
  transactionReceipts.forEach((receipt, index) => {
    console.log(`Transacción ${index + 1}: ${receipt.transactionHash}`);
  });
}

// Llamar a la función de envío de transacciones masivas
sendMassiveTransactions().catch(console.error);