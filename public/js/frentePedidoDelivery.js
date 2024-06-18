var CATEGORIAS = [];
var PRODUTOS = [];

$(function () {
	CATEGORIAS = JSON.parse($('#categorias').val())
	PRODUTOS = JSON.parse($('#produtos').val())
});


$('#kt_select2_3').change(() => {
	let id = $('#kt_select2_3').val()
	abrirPedido(parseInt(id));
})

$('#btn-salvar').click(() => {

	swal({
		title: "Impressão",
		text: "Deseja imprimir o cupom do pedido",
		icon: "warning",
		buttons: ["Não", "Sim"]
	})
	.then((sim) => {
		if(sim){
			$('#imprimir').val('1')
		}else{
			$('#imprimir').val('0')
		}
		$('#formPedido').submit();
	})

});

function getClientes(data){
	$.ajax
	({
		type: 'GET',
		url: path + 'pedidosDelivery/clientes',
		dataType: 'json',
		success: function(e){
			console.log(e);
			data(e)

		}, error: function(e){
			console.log(e)
		}

	});
}

function abrirPedido(cliente){
	
	$.post(path + 'pedidosDelivery/abrirPedidoCaixa', {cliente: cliente ,_token: $('#token').val()})
	.done((success) => {
		console.log(success)
		location.href = path + 'pedidosDelivery/frenteComPedido/'+success.id
	})
	.fail((err) => {
		console.log(err)
	})
}

$('#endereco').change(() => {
	let endereco = $('#endereco').val();
	let pedido_id = $('#pedido_id').val();

	$.post(path + 'pedidosDelivery/setEnderecoCaixa', 
	{
		endereco: endereco, 
		pedido_id: pedido_id, 
		_token: $('#token').val()
	})
	.done((success) => {
		console.log(success)
		location.href = path + 'pedidosDelivery/frenteComPedido/'+success.id
	})
	.fail((err) => {
		console.log(err)
	})
})

function categoria(cat){
	$('#cat_todos').html('Todos')

	desmarcarCategorias(() => {
		$('#cat_' + cat).addClass('ativo')
	})
	
	produtosDaCategoria(cat, (res) => {
		console.log(res)
		montaProdutosPorCategoria(res, (html) => {
			$('#prods').html(html)
		})
	})
}

function desmarcarCategorias(call){
	console.log(CATEGORIAS)
	CATEGORIAS.map((v) => {
		$('#cat_' + v.id).removeClass('ativo')
		$('#cat_' + v.id).removeClass('desativo')
	})
	$('#cat_todos').removeClass('desativo')
	$('#cat_todos').removeClass('ativo')

	call(true)
}

function produtosDaCategoria(cat, call){
	temp = [];
	if(cat != 'todos'){
		PRODUTOS.map((v) => {
			if(v.categoria_id == cat){
				temp.push(v)
			}
		})
	}else{
		temp = PRODUTOS
	}
	call(temp)
}

function montaProdutosPorCategoria(produtos, call){
	$('#prods').html('')

	let html = '';
	produtos.map((p) => {
		console.log(p)
		html += '<div class="col-sm-12 col-lg-6 col-md-6 col-xl-3" id="atalho_add">'
		html += '<div class="card card-custom gutter-b example example-compact">'
		html += '<div class="card-header" style="height: 200px;"'
		html += 'onclick="adicionarProdutoRapido(\''+ p.id +'\')">'

		if(p.produto.imagem == ''){
			html += '<img class="img-prod" src="/imgs/no_image.png">'
		}else{
			html += '<img class="img-prod" src="/imgs_produtos/'+p.produto.imagem+'">'
		}
		html += '<h6 style="font-size: 12px; width: 100%" class="kt-widget__label">'
		html += p.produto.nome + '</h6>'
		html += '<h6 style="font-size: 12px;" class="text-danger" class="kt-widget__label">'

		html += formatReal(p.valor) + '</h6>'
		
		html += '</div>'

		html += '<button type="button" onclick="adicionarProdutoRapidoComAdicional(\''+ p.id +'\')"' 
		html += 'class="btn btn-info"> + Adicional</button>'

		html += '</div></div>'
	})

	if(html != ""){
		call(html)
	}else{
		call("<p class='text-danger'>Nenhum produto nesta categoria!!</p>")
	}
}

function formatReal(v){
	return v.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});;
}

function adicionarProdutoRapido(id){
	let pedidoId = $('#pedido_id').val()
	if(pedidoId > 0){
		$('#kt_select2_1').val(id).change()
		setTimeout(() => {
			$('#formItem').submit()
		}, 300)
	}else{
		swal("Alerta", "Informe o cliente", "warning")
	}
}

$('#saveItemAdicional').click(() => {
	let qtd = $('#qtd-item').val()
	let observacao = $('#observacao-item').val()

	$('#quantidade').val(qtd)
	$('#observacao').val(observacao)
	setTimeout(() => {
		$('#formItem').submit()
	}, 200)
})

function adicionarProdutoRapidoComAdicional(id){
	let pedidoId = $('#pedido_id').val()
	if(pedidoId > 0){
		$('#kt_select2_1').val(id).change()
		$('#modal-adicional').modal('show')
	}else{
		swal("Alerta", "Informe o cliente", "warning")
	}
}
