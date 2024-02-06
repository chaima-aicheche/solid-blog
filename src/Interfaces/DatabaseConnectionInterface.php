<?

namespace App\Interfaces;

// Interface get BDD connection
interface DatabaseConnectionInterface{
    // Return instance of BDD connection
    public function connect();
}

?>