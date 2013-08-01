<?php
require("startup.php");

//Se non e' loggato, lo rimando alla pagina iniziale
if(!($user->isLogged())) {
	header("Location: index.php");
	exit();
}


$project=new project($registry);

//Accesso alla pagina consentito solo ai professionisti, cioe' con client_of=0
if($user->clientOf()>0) {
	header("Location:index.php");
} 

$data = array();

/*
 * Inserimento nuovo cliente
 */
if($request->post['action']=="insertClient") {
	$id_photo="user";
	
	
	
}
/*
/*
 * Ottengo la lista dei clienti del professionista
 */
$data['listaUtenti'] = $user->getClients();
$listaUserId = array();
foreach($data['listaUtenti'] as $ut) {
	$listaUserId[] = $ut['user_id'];
}

/*
 * Cancellazione cliente
 */
if($request->post['action']=="deleteClient") {
	//Controllo se il professionista ha i diritti per farlo
	if(in_array($request->post['user_id'],$listaUserId)) {
		$user->delete($request->post['user_id']);
		$data['feedback']=LANG_MANAGER_DELETE_CUSTOMER_SUCCESS;
	}
}


$data['page']="customers";

//Template
$template = new template($registry);

$template->data=& $data;

$content = $template->load(DIR_TEMPLATE . 'header.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'customers.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'right.php');

$template->render($content);

$content = $template->load(DIR_TEMPLATE . 'footer.php');

$template->render($content);

?>