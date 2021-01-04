
 <?php


$server = $_SERVER['HTTP_HOST'];

?>

    <link rel="stylesheet" href="<?php echo "css/apiCovid.css"?>"> <! -- acessa o arquivo de css para a parte estetica da pagina-->

<?php

//Carrega parametros de cabeçalho - Start
$options = array(

		'http' => array(

		'header' => "Contant-type: application/x-www-form-urlencoded\r\n",

		'method' => 'GET',

		), 'ssl' => array('verify_peer' => false, 'verify_peer_name' => false)

	);
//Carrega parametros de cabeçalho - End
	
//Transforma cabeçalho em ponteiros - Start
	$context = stream_context_create($options);
//Transforma cabeçalho em ponteiros - Start

//Realiza leitura End Point - Start
	$obj = file_get_contents("https://covid19-brazil-api.now.sh/api/report/v1", false, $context);
//Realiza leitura End Point - End

//Transforma Json em Array - Start

	$result = json_decode($obj, true);

//Transforma Json em Array - End

	  echo '<pre>';
	///var_dump($result['fases']['3062']['classificacao']);
//var_dump($result['data']);
	
  	  echo '</pre>';
//exit();$arrayPontosTime[$contact['id']] = $contact['pg']['total'];
  
///executa arrray das datas e resuldodo dos jogos start 
		
	if( $_SERVER['HTTP_HOST']== 'localhost'){

	$okdb = mysqli_connect('localhost','root', '', 'covid19');

}else if($_SERVER['HTTP_HOST']== 'ivk.rf.gd'){

	$okdb = mysqli_connect('sql303.epizy.com', 'epiz_26802638', 'moPXHhMskO', 'epiz_26802638_covid19');

}
//echo $_SERVER['HTTP_HOST'];

if (!$okdb) {
die('Problemas ao selecionar a base de dados!!!');
}else{

	echo '';
};
		
?>

<body>
	<center><table class="estados"style="border-collapse:separate!important;border-spacing: 0!important;">
		<tr class="titulo">
			<h1>Covid-19 Brasil</h1>
		</tr>

	<tr>
		<td  class="subTitulo1"><h3>ESTADOS</h3></td> 
	
		<td  class="subTitulo2"><h3>DADOS</h3></td>
	</tr>
	<?php foreach ($result['data'] as $contatEst){  

		//echo $contatEst['uid'].'--'.$contatEst['uf'].'--'.$contatEst['state'].'--'.$contatEst['cases'].'--'.$contatEst['deaths'].'--'.$contatEst['suspects'].'--'.$contatEst['refuses'].'--'.$contatEst['datetime'].'<br>';?>
	
		<td rowspan="4"class="nomeEstado">
			<img src="css/imagem/<?php echo $contatEst['uid']?>.png" style="width: 60px;height: 40px;"><br>

		<?php  echo $contatEst['state'];?>

		</td>

		<td class="casos">
			Casos: <?php echo $contatEst['cases'];  ?>
		</td>
		<tr> 
			
			<td class="mortes">
				Mortes <?php echo $contatEst['deaths'];  ?>
			</td>
		</tr>
		<tr>
			
			<td class="suspeitos">
				Suspeitos: <?php echo $contatEst['suspects'];  ?>
			</td>
		</tr>
		<tr>
			
			<td class="recuperados">
				Recuperados: <?php echo $contatEst['refuses'];  ?>
			</td>
		</tr>

</tr>
<?php } ?>
</center>


<?php


foreach ($result['data'] as $contatEst){ 
	$uid      = $contatEst['uid'];
    $uf       = $contatEst['uf'];
    $estado   = $contatEst['state'];
    $casos    = $contatEst['cases'];
    $mortes   = $contatEst['deaths'];
    $suspeitos= $contatEst['suspects'];
    $curados  = $contatEst['refuses'];

//$okdb = mysqli_connect("sql303.epizy.com", "epiz_26802638", "moPXHhMskO", "epiz_26802638_covid19");
///conexão com o banco de dados
    //$okdb = mysqli_connect("localhost", "root", "", "covid19");///conexão com o banco de dados


$consulta = "SELECT * FROM `covidbrasil` WHERE uid = '".$uid."'";
///inserir no banco star
$resultConsulta = mysqli_query($okdb, $consulta);

 	$execQuery = mysqli_num_rows($resultConsulta);
 	//var_dump($result_consult);

 		if($execQuery == 0){
    //executera a QUERY start
               $inserir = "
                      INSERT INTO covidbrasil 
                          (
                           uid,
                           uf,
                           estado,
                           casos,
                           mortes,
                           suspeitos,
                           curados,
                           data                       
                           
                           ) VALUES(
                                '".$uid."',
                                '".$uf."',
                                '".$estado."',
                                '".$casos."',
                                '".$mortes."',
                                '".$suspeitos."',
                                '".$curados."',
                                '".date("Y-m-d")."'
                                                       
                                ); ";
                               // echo $inserir.'<br>';
           $resultado = mysqli_query($okdb,$inserir)or 
           die(false);


             //echo "OK mensagem gravado com sucesso!!"*/
}else{
           $update = "
		           UPDATE `covidbrasil` 
		           SET 
		           
		           uf='".$uf."',
		           estado= '".$estado."',
		           casos='".$casos."',
		           mortes='".$mortes."',
		           suspeitos='".$suspeitos."',
		           curados='".$curados."',
		           data='".date("Y-m-d")."' 
		           WHERE  
		           uid = '".$uid."'" ;
		           /// echo $update.'<br>';
            
            $resultUpdate = mysqli_query($okdb,$update)or 
           die(false);

}

}
?>

	
	
		
