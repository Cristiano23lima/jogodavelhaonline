<link rel="stylesheet" type="text/css" href="plugins/jquery-loading-master/dist/jquery.loading.min.css">
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<div class="col-md-3">
				<button class="btn btn-primary" type="button" id="pesquisar_jog">Procurar jogador...</button>
			</div>
		</div>
	</div><br>
	<div class="row">
		<div class="col-md-7">
			<div class="row">
				<div class="linha">
					<div id="1" class="quad"></div>
					<div id="2" class="quad"></div>
					<div id="3" class="quad"></div>
				</div>
			</div>
			<div class="row">
				<div class="linha">
					<div id="4" class="quad"></div>
					<div id="5" class="quad"></div>
					<div id="6" class="quad"></div>
				</div>
			</div>
			<div class="row">
				<div class="linha">
					<div id="7" class="quad"></div>
					<div id="8" class="quad"></div>
					<div id="9" class="quad"></div>
				</div>
			</div>
		</div>
		<div class="col-md-5">
			<div class="card">
				<h5 class="card-header">Dados do jogo</h5>
				<div class="card-body">
					<div class="row">
						<label class="col-md-4">Jogadores: </label>
						<label><strong id="jg1"> Jogador 1</strong> X <strong id="jg2">Jogador 2</strong></label>
					</div>
					<div class="row">
						<label class="col-md-4">Máximo de partidas: <b>3</b></label>
					</div>
					<div class="row">
						<label id="pj" class="col-md-4">Partidas jogadas: <strong>0</strong></label>
					</div>
					<div class="row">
						<label id="pg" class="col-md-4">Partidas ganhas: <strong>0</strong></label><br>
					</div>
					<div class="row">
						<label id="emp" class="col-md-4">Partidas empatadas: <strong>0</strong></label>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="painel">
</div>
<script type="text/javascript" src="plugins/jquery-loading-master/dist/jquery.loading.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var partida = null, nome, nome_adv;
		var vez, verifJogada;
		var interval = null, f_interval = null;
		var prox;
		var venc_jog1 = 0, venc_jog2 = 0, emp = 0, rodada = 3, pj = 0, pg = 0;

		//funcao pesquisar jogador e iniciar uma partida
		$("#pesquisar_jog").on("click", function(e){
			e.preventDefault();
			$('body').loading({
				message: 'Procurando Jogador...'
			});
			var id_jog = <?php echo $_SESSION['id']; ?>;
			var dados = {'id_jogador' : id_jog};
			var result = null;
			$.ajax({
				data: dados,
				url: 'funcoes/pesquisa_jog.php',
				method: 'post',
				dataType: 'html',
				success: function(s){
					result = s;
					if($.isNumeric(result)){
						$('body').loading('stop');
						var dados = {'id_j':result};
						$.ajax({
							data: dados,
							method: 'post',
							dataType: 'html',
							url: 'funcoes/formando_partida.php',
							error: function(e){
								alert('ERRO: '+e);
							},
							success: function(s){
								if($.isNumeric(s)){
									partida = s;
									$("#pesquisar_jog").attr('disabled', 'disabled');
									alert("A partida vai começar...");
									$.ajax({
										data: {'id_adv':result},
										dataType: 'json',
										type: 'post',
										url: 'funcoes/dados_jogadores.php',
										success: function(s){
											for(var i = 0; i < s.length; i++){
												if(s[i].id == id_jog){
													$("#jg1").text('');
													$("#jg1").text(s[i].nome);
													nome = s[i].nome;
												}else{
													$("#jg2").text('');
													$("#jg2").text(s[i].nome);
													nome_adv = s[i].nome;
												}
											}
											setIntervalReset(true);
										}
									})
								}else{
									alert(s);
								}
								$('body').loading('stop');
							}
						})
					}else{
						alert(result);
						$('body').loading('stop');
					}
				}
			})
		})

		//funcao onde o jogador realiza a jogada
		$(".quad").on("click", function(e){
			e.preventDefault();
			if(partida != null && partida != ''){
				var id_quad = $(this).attr('id');
				var char;
				if($("#"+id_quad).text() != 'X' && $("#"+id_quad).text() != 'O'){
					$.ajax({
						data: {'partida':partida},
						method: 'post',
						dataType: 'html',
						url: 'funcoes/verifica_partida.php',
						error: function(e){
							alert('ERRO: '+e);
						},
						success: function(s){
							vez = s;
							$.ajax({
								data: {'partida':partida},
								method: 'post',
								url: 'funcoes/verif_vez_jog.php',
								dataType: 'json',
								success: function(s){
									prox = s;
									if(vez == 0){
										char = 'X';
									}else if(vez == 1){
										char = 'O';
									}

									if(prox == vez){
										//manda os dados da jogada para preenchimento do tabuleiro nos dois lados da tela
										var dados = {'posicao':id_quad, 'peca':char, 'id_partida':partida, 'vez':vez};
										$.ajax({
											url: 'funcoes/jogo.php',
											type: 'post',
											data: dados,
											dataType: 'html'
										})
										jogo(char,id_quad);
									}else{
										alert("A vez é do adversario");
									}
								}
							})

						}
					})
				}else{
					alert("Esse campo já está preenchido!");
				}
			}else{
				alert("Por favor. Clique em procura jogador para começar uma partida.");
			}
		})
		
		//funcao de preencher o tabuleiro
		function jogo(char, quad){
			$("#"+quad).text(char);
		}

		//funcao de verificar tabuleiro
		function verifica(vez){
			if($("#1").text() == 'X' && $("#2").text() == 'X' && $("#3").text() == 'X'){
				return 1;
			}else if($("#4").text() == 'X' && $("#5").text() == 'X' && $("#6").text() == 'X'){
				return 1;
			}else if($("#7").text() == 'X' && $("#8").text() == 'X' && $("#9").text() == 'X'){
				return 1;
			}else if($("#1").text() == 'X' && $("#4").text() == 'X' && $("#7").text() == 'X'){
				return 1;
			}else if($("#2").text() == 'X' && $("#5").text() == 'X' && $("#8").text() == 'X'){
				return 1;
			}else if($("#3").text() == 'X' && $("#6").text() == 'X' && $("#9").text() == 'X'){
				return 1;
			}else if($("#1").text() == 'X' && $("#5").text() == 'X' && $("#9").text() == 'X'){
				return 1;
			}else if($("#3").text() == 'X' && $("#5").text() == 'X' && $("#7").text() == 'X'){
				return 1;
			}else if($("#1").text() == 'O' && $("#2").text() == 'O' && $("#3").text() == 'O'){
				return 2;
			}else if($("#4").text() == 'O' && $("#5").text() == 'O' && $("#6").text() == 'O'){
				return 2;
			}else if($("#7").text() == 'O' && $("#8").text() == 'O' && $("#9").text() == 'O'){
				return 2;
			}else if($("#1").text() == 'O' && $("#4").text() == 'O' && $("#7").text() == 'O'){
				return 2;
			}else if($("#2").text() == 'O' && $("#5").text() == 'O' && $("#8").text() == 'O'){
				return 2;
			}else if($("#3").text() == 'O' && $("#6").text() == 'O' && $("#9").text() == 'O'){
				return 2;
			}else if($("#1").text() == 'O' && $("#5").text() == 'O' && $("#9").text() == 'O'){
				return 2;
			}else if($("#3").text() == 'O' && $("#5").text() == 'O' && $("#7").text() == 'O'){
				return 2;
			}else if(($("#1").text() != '') && ($("#2").text() != '') && ($("#3").text() != '') && ($("#4").text() != '') && ($("#5").text() != '') && ($("#6").text() != '') && ($("#7").text() != '') && ($("#8").text() != '') && ($("#9").text() != '')){
				return 3;
			}else{
				return 0;
			}
		}

		//atualiza o tabuleiro e verifica se alguem já ganhou
		function setIntervalReset(bool){
			f_interval = function(){
				$.ajax({
					url: 'funcoes/atualiza_tab.php',
					type: 'post',
					data: {'partida':partida},
					dataType: 'json',
					success: function(s){
						for (var i = 0; i < s.length; i++) {
							$("#"+s[i]['posicao']).text(s[i]['peca']);
						}
						verifJogada = verifica(vez);
						verifPartida();
						fecharPartida();
					}
				})
			}
			interval = setInterval(f_interval, 1000);
		}
		
		//verifica se já teve um empate ou um gaiador na rodada atual
		function verifPartida(){
			if(verifJogada == 1 && vez == 0){
				clearInterval(interval);
				venc_jog1++;
				rodada--;
				alert("Parabéns. Você Venceu essa rodada!");
				$("#1").text('');
				$("#2").text('');
				$("#3").text('');
				$("#4").text('');
				$("#5").text('');
				$("#6").text('');
				$("#7").text('');
				$("#8").text('');
				$("#9").text('');
				$.ajax({
					data: {'partida':partida, 'rodada': rodada, 'venc_jog1':venc_jog1, 'venc_jog2':venc_jog2, 'empate':emp},
					type: 'post',
					url: 'funcoes/reinicia_tab.php',
					dataType: 'html',
					success: function(s){
						alert(s);
						pj++;
						pg++;
						$("#pj strong").text('');
						$("#pj strong").text(pj);
						$("#pg strong").text('');
						$("#pg strong").text(pg);
						setIntervalReset(true);
					}
				})
			}else if(verifJogada == 2 && vez == 1){
				clearInterval(interval);
				venc_jog2++;
				rodada--;
				alert("Parabéns. Você Venceu essa rodada!");
				$("#1").text('');
				$("#2").text('');
				$("#3").text('');
				$("#4").text('');
				$("#5").text('');
				$("#6").text('');
				$("#7").text('');
				$("#8").text('');
				$("#9").text('');
				$.ajax({
					data: {'partida':partida, 'rodada': rodada, 'venc_jog1':venc_jog1, 'venc_jog2':venc_jog2, 'empate':emp},
					type: 'post',
					url: 'funcoes/reinicia_tab.php',
					dataType: 'html',
					success: function(s){
						alert(s);
						pj++;
						pg++;
						$("#pj strong").text('');
						$("#pj strong").text(pj);
						$("#pg strong").text('');
						$("#pg strong").text(pg);
						setIntervalReset(true);
					}
				})
				
			}else if(verifJogada == 1 && vez == 1){
				clearInterval(interval);
				venc_jog1++;
				rodada--;
				alert("Que pena. Você perdeu essa rodada!");
				$("#1").text('');
				$("#2").text('');
				$("#3").text('');
				$("#4").text('');
				$("#5").text('');
				$("#6").text('');
				$("#7").text('');
				$("#8").text('');
				$("#9").text('');
				$.ajax({
					data: {'partida':partida, 'rodada': rodada, 'venc_jog1':venc_jog1, 'venc_jog2':venc_jog2, 'empate':emp},
					type: 'post',
					url: 'funcoes/reinicia_tab.php',
					dataType: 'html',
					success: function(s){
						alert(s);
						pj++;
						$("#pj strong").text('');
						$("#pj strong").text(pj);
						$("#pg strong").text('');
						$("#pg strong").text(pg);
						setIntervalReset(true);
					}
				})
			}else if(verifJogada == 2 && vez == 0){
				clearInterval(interval);
				venc_jog2++;
				rodada--;
				alert("Que pena. Você perdeu essa rodada!");
				$("#1").text('');
				$("#2").text('');
				$("#3").text('');
				$("#4").text('');
				$("#5").text('');
				$("#6").text('');
				$("#7").text('');
				$("#8").text('');
				$("#9").text('');
				$.ajax({
					data: {'partida':partida, 'rodada': rodada, 'venc_jog1':venc_jog1, 'venc_jog2':venc_jog2, 'empate':emp},
					type: 'post',
					url: 'funcoes/reinicia_tab.php',
					dataType: 'html',
					success: function(s){
						alert(s);
						pj++;
						$("#pj strong").text('');
						$("#pj strong").text(pj);
						$("#pg strong").text('');
						$("#pg strong").text(pg);
						setIntervalReset(true);
					}
				})
			}else if(verifJogada == 3){
				clearInterval(interval);
				emp++;
				rodada--;

				alert("Houve um empate nessa rodada");
				$("#1").text('');
				$("#2").text('');
				$("#3").text('');
				$("#4").text('');
				$("#5").text('');
				$("#6").text('');
				$("#7").text('');
				$("#8").text('');
				$("#9").text('');
				$.ajax({
					data: {'partida':partida, 'rodada': rodada, 'venc_jog1':venc_jog1, 'venc_jog2':venc_jog2, 'empate':emp},
					type: 'post',
					url: 'funcoes/reinicia_tab.php',
					dataType: 'html',
					success: function(s){
						alert(s);
						pj++;
						$("#pj strong").text('');
						$("#pj strong").text(pj);
						$("#pg strong").text('');
						$("#pg strong").text(pg);
						$("#emp strong").text('');
						$("#emp strong").text(emp);
						setIntervalReset(true);
					}
				})
			}
		}


		//se todas as rodadas já tiverem sido jogadas, essa função irá finalizar a partida dando o ganhador final
		function fecharPartida(){
			if(VerificaFimPartida(rodada)){
				var result = verificaVencedor();
				$.ajax({
					data: {'partida' : partida, 'result':result},
					dataType: 'html',
					method: 'post',
					url: 'funcoes/fim_partida.php',
					success: function(s){
						if($.isNumeric(s)){
							if(s == 3){
								alert("Partida empatada!");
							}else if(s == <?php echo $_SESSION['id']; ?>){
								alert(nome+" venceu a partida!");
							}else{
								alert(nome_adv+" venceu a partida!");
							}
							location.reload(true);
						}else{
							alert(s);
							location.reload(true);
						}
					}
				});
			}
		}

		function verificaVencedor(){
			var pontJ1 = (venc_jog1*3)+(emp*1);
			var pontJ2 = (venc_jog2*3)+(emp*1);

			if(pontJ1 > pontJ2){
				return 1;
			}else if(pontJ2 > pontJ1){
				return 2;
			}else{
				return 3;
			}
		}

		//verifica se o usuario estar na rodada final e se ele finalizou ela
		function VerificaFimPartida(rodada){
			if(rodada == 0){
				return 1;
			}else{
				return 0;
			}
		}
	})
</script>