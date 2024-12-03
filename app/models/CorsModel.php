<?php
/*
The model represents the application's data and business logic. It manages data retrieval, 
storage, and manipulation, often interacting with the database. 
The model encapsulates rules and validation to ensure data integrity.

@author Victor Béser
*/
class CorsModel
{
    public static function setCors()
    {
        // Definir os cabeçalhos CORS
        header("Access-Control-Allow-Origin: *");  // Permite acesso de qualquer origem
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Permite os métodos HTTP necessários
        header("Access-Control-Allow-Headers: Content-Type"); // Permite os cabeçalhos necessários
        header("Access-Control-Allow-Credentials: true"); // Se for necessário enviar cookies ou autenticação
    }
}
?>
