<?php


class mysqlDB {

        private $_host = '';
        private $_user = '';
    private $_password = '';
    private $_database = '';

  private $_connection = null;

         private $_sql = '';
      private $_result = null;

    private $_insertId = 0;

  private $_errormessage = '';
   private $_errornumber = 0;

  public function __construct($host = null,$user=null,$passwort = null,$database = null)
  {

    if($host !== null)              $this->_host = $host;
    if($user !== null)              $this->_user = $user;
    if($passwort !== null)      $this->_password = $passwort;
    if($database !== null)      $this->_database = $database;

    if(strlen($this->_host) >0 && strlen($this->_user) >0 && strlen($this->_database) >0)
    {
      $this->connect();
 //     $this->query('SET CHARACTER SET "utf8"');

//      echo "Connect: ";
//      print_r($this->_connection);
    }
    
  }

  public function  __destruct()
  {
    if($this->_connection !== null) $this->close();
  }

  public function connect()
  {
    if(strlen($this->_host) >0 && strlen($this->_user) >0 && strlen($this->_database) >0)
    {
      $this->_connection = @mysql_connect($this->_host,$this->_user,$this->_password);

      if($this->isConnected() != true)
      {
        $this->setError();
      }
      else
      {
        mysql_select_db($this->_database, $this->_connection);
      }
    }

  }

  public function isConnected()
  {
    if(gettype($this->_connection) == 'resource')
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  
  public function close()
  {
    if(gettype($this->_connection) == 'resource')
    {
      $result = mysql_close($this->_connection);
      if(!$result)
      {
        $this->setError();
        return false;
      }
      else
      {
        return true;
      }
    }

  }

  public function query($sql)
  {
      
 //   echo "Query: ".$sql."<br />";  
    $this->_sql = $sql;
    
    $this->_result = @mysql_query($this->_sql,$this->_connection);

    if(!$this->_result)
    {
      $this->setError();
      return false;
    }
    else
    {

      if(strpos(strtolower($sql),'insert') === 0)
      {
        $this->_insertId = @mysql_insert_id();

        if($this->_insertId === false)
        {
          $this->setError();
        }
      }
//  echo "_result: ".$this->_result;
      return $this->_result;
    }
    
  }

  public function getResult()
  {
    return $this->_result;
  }

  public function rowCount()
  {
    if($this->_result)
    {
      return @mysql_num_rows($this->_result);
    }
 else {
      return false;
    }

  }

  public  function getAffectedRows()
  {
    return mysql_affected_rows();
  }


  public function getLastInsertId()
  {
    if(!$this->_insertId)
    {
      return false;
    }
    else
    {
      return $this->_insertId;
    }
  }

    
  static public function SQLLimit($limit)
  {
      $sql='';
      if( !is_null($limit) && is_int($limit) && !is_array($limit)){
         $sql .= " LIMIT ".$limit;
          
      }
      return $sql;
  }
  
  
  static public function SQLOrder($order)
  {
      $sql='';
      if(!is_null($order) && $order !== ''){
          if(!is_array($order)){
             $sql .= " ORDER BY `".$order."` ASC ";
          }else{
             if(count($order)==2){
                $sql .= " ORDER BY `".$order[0]."` ".$order[1];   
             }
          }
      }
      return $sql;
  }

  
  static public function SQLColumns($columns, $quote = '`')
  {
    $sql = '';

    if(is_array($columns))
    {
      foreach($columns as $key => $value)
      {
          
        $value = trim($value);
        if(strlen($sql) == 0)
        {

          $sql .= $quote. $value . $quote;
        }
        else{
          $sql .= ' ,'.$quote. $value . $quote;
        }
      }
    }

    return $sql;
  }


  static public function SQLWhere($where)
  {
    $sql = '';
    if($where != null){
       foreach ($where as $key => $value) {
          if(!is_numeric($value))
          {
              $value = '"'. $value .'"';  
          }  
          if(strlen($sql) == 0 )
          {
            $sql .= " WHERE `".$key . "` = " . $value;
          }
          else{

            $sql .= " AND `" . $key . "` = " . $value;
          }
       }
    }
        
    return $sql;
  }
  


  static public function SQLSelect($table = null, $where =null, $columns =null)
  {

    if(!is_null($columns) && $columns != '')
    {
      $sql = self::SQLColumns($columns);
    }
    else{
      $sql = '*';
    }

    $sql = 'SELECT ' . $sql . ' FROM `' . $table . '`';

    if(! is_null($where))
    {

      $sql .= self::SQLWhere($where);
    }
    


  return $sql;
  }

  static public function SQLInsert($table,$values)
  {
    $columns = self::SQLColumns(array_keys($values));
    $values = self::SQLColumns($values, "'");


    $sql= 'INSERT INTO `'. $table . '` ('.$columns. ') VALUES (' .$values . ')';


    return $sql;
    
  }

  static  public function SQLUpdate($table, $values, $where)
  {
    $sql = '';
    foreach ($values as $key => $value) {
      if(!is_int($value)){
           $value = '"'. $value .'"';
      }  
      if(strlen($sql) == 0)
      {
        $sql = "`" . $key . "` = " . $value;
      }
 else {
        $sql .= ", `" . $key . "` = " . $value;

      }
    }

    $sql = "UPDATE `" . $table . "` SET " .$sql;

    if(is_array($where))
    {

      $sql .= self::SQLWhere($where);

    }

    return $sql;
    
  }


  static public function SQLDelete($table, $where)
  {
    $sql = 'DELETE FROM `' . $table . '`';

    if(is_array($where))
    {
      $sql .= self::SQLWhere($where);
    }

    return $sql;
    
  }


  public function select($table = null, $where =null, $columns =null, $order = null, $limit = null)
  {

    $sql = self::SQLSelect($table, $where, $columns);    
    
    $sql .= self::SQLOrder($order);

    $sql .= self::SQLLimit($limit);
        
    $result = $this->query($sql);

    if(!$result)
    {
      return false;
    }
    else
    {
      return $result;
    }
  }

  public function insert($table, $values)
  {
      foreach ($values as $value) {
        $value = mysql_real_escape_string($value);
    }
    $sql = self::SQLInsert($table,$values);

    $this->query($sql);
    
  }

  public function update($table, $values, $where)
  {
    foreach ($values as $value) {
        $value = mysql_real_escape_string($value);
    }
    $sql = self::SQLUpdate($table, $values, $where);

    $this->query($sql);
    
  }


  public function delete($table,$where)
  {
    $sql = self::SQLDelete($table, $where);
    $this->query($sql);
    
  }


  public function dataTable()
  {
    $html = '';

    $header= false;
    if($this->_result)
    {
      $html = '<table class="datatable">';

      while ($row = mysql_fetch_object($this->_result)) {

        if(!$header)
        {
          $html .= '<tr>';

          foreach ($row as $key => $value)
          {
            $html .= '<th>'. $key .'</th>';

          }
          
          $html .= '</tr>';
          $header = true;
        }

        $html .= '<tr>';
        foreach($row as $key => $value)
        {
            $html .= '<td>'. $value .'</td>';

          
        }
        $html .= '</tr>';

      }

      $html .= '</table>';
    }

    return $html;

  }


  private function setError($message = '', $number = 0)
  {

  try {
    if(strlen($message) > 0)
    {

    }
    else
    {
      if($this->isConnected())
      {
        $this->_errormessage = @mysql_error($this->_connection);
      }
      else
      {
        $this->_errormessage = @mysql_error();
      }
      
    }

    if($number <> 0)
    {
      $this->_errornumber = $number;
    }
    else
    {
      if($this->isConnected())
      {
        $this->_errornumber = @mysql_errno($this->_connection);
      }
      else
      {
        $this->_errornumber = @mysql_errno();
      }
    }


  } catch (Exception $exc) {
    $this->_errormessage =$exc->getMessage();
  }


  if(strlen($this->_errormessage) > 0)
  {
    echo "<pre>";
    throw new Exception($this->_errormessage . '('. __LINE__ . ')');
    echo "</pre>";

  }


  }


}

?>
