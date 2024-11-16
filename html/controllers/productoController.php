 <?php

    
    class ProductoController {


        private  $db_conn;

        public function __construct($conn) {
            $this->db_conn = $conn;
        }


        public function consultarProductos(){

            $query = "SELECT * FROM productos";
            $stmt = $this->db_conn->prepare(query: $query);
            $stmt->execute();
            $result = $stmt->get_result();



            $stmt->close();
            $this->db_conn->close();

            return $result;

        }


    }

?>