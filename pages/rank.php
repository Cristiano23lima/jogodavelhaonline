<?php 
	include "funcoes/classes/dados.php";
	$crud = new Crud();
	$page = (isset($_GET['pagina'])?$_GET['pagina']:1);

	$limite = 30;
	$comeco = (($page-1)*$limite);

	$sql = "SELECT u.nome as nome, r.pontos as pontos FROM tb_usuario as u INNER JOIN tb_rank as r ON u.id = r.id_usuario ORDER BY r.pontos";
	$result = $crud->select($sql, null);
	$sql.=" DESC LIMIT ".$comeco." ,".$limite." "; 
	$rest = $crud->select($sql, null);
	$quant = ceil(sizeof($result)/$limite);
	
 ?>
 <div class="container">
 	<div class="card">
 		<h5 class="card-header">Rank dos jogadores</h5>
 		<div class="card-body">
		 	<div class="row d-flex justify-content-center" id="tableRank">
				<div class="col-md-8">
					<table id="tabelaRank" class="table table-striped table-bordered">
					    <thead>
					        <tr>
					        	<th>Posição</th>
					            <th>Jogador</th>
					            <th>Pontos</th>
					        </tr>
					    </thead>
					    <tbody>
					    	<?php 
								$posicao = array();
								$j = 0;
								while($j < $limite){
									$posicaoA = array();
									$posicaoA[] = $comeco+1;

									$posicao[] = $posicaoA;

									$comeco++;
									$j++;
								}

								$cont = sizeof($rest);
								if($cont > 0){
									$i = 0;
									while($i < sizeof($rest)){ ?>
										<tr>
											<th><?php echo $posicao[$i][0]; ?></th>
											<th><?php echo $rest[$i][0]; ?></th>
											<th><?php echo $rest[$i][1]; ?></th>
										</tr>						
								<?php $i++;	}
								}else{ ?>
									<tr>Nenhum registro encontrado</tr>
							<?php	} ?>
					    </tbody>
					</table>
					<nav aria-label="...">
					  <ul class="pagination">
					    <li class="page-item <?php if($_GET['pagina'] == 1){ echo 'disabled'; } ?>">
					      <a class="page-link" href="<?php echo $_GET['pagina']-1; ?>" tabindex="-1">Anterior</a>
					    </li>
					    <?php 
					    	$k = 0; 
							while($k < $quant){ ?>
								<li class="page-item <?php if($page == $k+1){ echo "active"; } ?>">
									<a class="page-link" href="<?php if($page == $k+1){ echo "#"; }else{ echo ''.($k+1).' '; } ?>"><?php echo $k+1; ?></a>
								</li>
						<?php	$k++; }
						 ?>
					    <li class="page-item <?php if($_GET['pagina'] >= $quant){ echo 'disabled'; } ?>">
					      <a class="page-link" href="<?php echo $_GET['pagina']+1; ?>">Proximo</a>
					    </li>
					  </ul>
					</nav>
					<div class="btn-group" role="group" aria-label="Basic example">
					
					</div>
				</div>
			</div>
 		</div>
 	</div>
 </div>