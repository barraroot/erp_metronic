$(function () {
	setInterval(() => {
		verificaArquivoPedidos((resp) => {

		});

		verificaArquivoPedidosDelivery((resp) => {

		});
		
	}, 5000);
});

function verificaArquivoPedidos(call){
	$.get(path + 'geraArquivo/pedidos')
	.done((res) => {
		console.log(res)
	})
	.fail((err) => {
		console.log("Erro ao buscar pedidos", err)
	})
}

function verificaArquivoPedidosDelivery(call){
	$.get(path + 'geraArquivo/pedidosDelivery')
	.done((res) => {
		// console.log(res)
	})
	.fail((err) => {
		console.log("Erro ao buscar pedidos delivery", err)
	})
}