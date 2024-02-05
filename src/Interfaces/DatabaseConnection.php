<?

namespace App\Interfaces;

// Interface get BDD connection
interface DatabaseConnection{
    // Return instance of BDD connection
    public function connect();
}

?>