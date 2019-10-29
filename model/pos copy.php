<?php
class pos extends dbconn {
	public function __construct()
	{
		$this->initDBO();
	}
 /******************************************************************************
    START TABEL m_item
    *******************************************************************************/
    public function getListItem()
    {
      $db = $this->dblocal;
      try
      {
       $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan,t.* FROM m_item t, 
        (SELECT @rownum := 0) r ORDER BY id_item ASC");
       $stmt->execute();
       $stat[0] = true;
       $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $stat;
     }
     catch(PDOException $ex)
     {
       $stat[0] = false;
       $stat[1] = $ex->getMessage();
       return $stat;
     }
   }

   public function getItem($id_item){
    $db = $this->dblocal;
    try
    {
     $stmt = $db->prepare("select a.* from m_item a where a.id_item = :id ");
     $stmt->bindParam("id",$id_item);
     $stmt->execute();
     $stat[0] = true;
     $stat[1] = $stmt->fetch(PDO::FETCH_ASSOC);
     return $stat;
   }
   catch(PDOException $ex)
   {
     $stat[0] = false;
     $stat[1] = $ex->getMessage();
     return $stat;
   }
 }


 public function updateItem($iditem,$item_name,$loc,$unit,$stock,$terms,$price,$fprice,$note)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_item 
    SET  item_name = UPPER(:item_name),
    loc = UPPER(:loc),
    unit= :unit,
    stock= :stock, 
    terms= :terms,
    price= :price,
    fprice= :fprice,
    note= :note
    WHERE id_item= :iditem;");

   $stmt->bindParam("iditem",$iditem);
   $stmt->bindParam("item_name",$item_name);
   $stmt->bindParam("loc",$loc);
   $stmt->bindParam("unit",$unit);
   $stmt->bindParam("stock",$stock);
   $stmt->bindParam("terms",$terms);
   $stmt->bindParam("price",$price);
   $stmt->bindParam("fprice",$fprice);
   $stmt->bindParam("note",$note);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success Edit!";

   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function saveItem($item_name,$loc,$unit,$stock,$terms,$price,$fprice,$note){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveItem(:item_name,:loc,:unit,:stock,:terms,:price,:fprice,:note)");
   $stmt->bindParam("item_name",$item_name);
   $stmt->bindParam("loc",$loc);
   $stmt->bindParam("unit",$unit);
   $stmt->bindParam("stock",$stock);
   $stmt->bindParam("terms",$terms);
   $stmt->bindParam("price",$price);
   $stmt->bindParam("fprice",$fprice);
   $stmt->bindParam("note",$note);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success save!";
   $stat[2] =  $stmt->fetchColumn(0);


   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function deleteItem($iditem)
{
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("delete from m_item where id_item = :id");
   $stmt->bindParam("id",$iditem);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success Delete!";
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function autoCompleteItem($term)
{
  $trm = "%".$term."%";
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("SELECT a.* FROM m_item a WHERE  item_name like :term or id_item  like :term order by item_name asc");
   $stmt->bindParam("term",$trm);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}
/*******************************************************************************
 END OF TABEL M_Item
 *******************************************************************************/






 /******************************************************************************
    START TABEL m_Request
    *******************************************************************************/
    public function getListRequest()
    {
      $db = $this->dblocal;
      try
      {
       $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan,t.* FROM m_request t, 
        (SELECT @rownum := 0) r ORDER BY id_request ASC");
       $stmt->execute();
       $stat[0] = true;
       $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $stat;
     }
     catch(PDOException $ex)
     {
       $stat[0] = false;
       $stat[1] = $ex->getMessage();
       return $stat;
     }
   }

   public function getRequest($id_request){
    $db = $this->dblocal;
    try
    {
     $stmt = $db->prepare("select a.* from m_request a where a.id_request = :id ");
     $stmt->bindParam("id",$id_request);
     $stmt->execute();
     $stat[0] = true;
     $stat[1] = $stmt->fetch(PDO::FETCH_ASSOC);
     return $stat;
   }
   catch(PDOException $ex)
   {
     $stat[0] = false;
     $stat[1] = $ex->getMessage();
     return $stat;
   }
 }


 public function updateRequest($idrequest,$request_name,$commodity,$stock,$unit,$price,$allowed_credit,$cover_value,$bond_value,$handling_type,$interest_rate,$offtaker_rate,$note)
 {

  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_request
    SET  request_name = UPPER(:request_name),
    commodity= :commodity,
    unit= :unit,
    stock= :stock, 
    price= :price,
    bond_value= :bond_value,
    cover_value= :cover_value,
    handling_type= :handling_type,
    allowed_credit= :allowed_credit,
    interest_rate= :interest_rate,
    offtaker_rate= :offtaker_rate,
    note= :note 
    WHERE id_request= :idrequest;");

   $stmt->bindParam("idrequest",$idrequest);
   $stmt->bindParam("request_name",$request_name);
   $stmt->bindParam("commodity",$commodity);
   $stmt->bindParam("stock",$stock);
   $stmt->bindParam("unit",$unit);
   $stmt->bindParam("price",$price);
   $stmt->bindParam("allowed_credit",$allowed_credit);
   $stmt->bindParam("bond_value",$bond_value);
   $stmt->bindParam("cover_value",$cover_value);
   $stmt->bindParam("handling_type",$handling_type);
   
   $stmt->bindParam("interest_rate",$interest_rate);
   $stmt->bindParam("offtaker_rate",$offtaker_rate);
   $stmt->bindParam("note",$note);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success Edit!";
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function saveRequest($request_name,$commodity,$stock,$unit,$price,$allowed_credit,$cover_value,$bond_value,$handling_type,$interest_rate,$offtaker_rate,$note){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveRequest(:request_name,:commodity,:stock,:unit,:price,:allowed_credit,:cover_value,:bond_value,:handling_type,:interest_rate,:offtaker_rate,:note)");
   $stmt->bindParam("request_name",$request_name);
   $stmt->bindParam("commodity",$commodity);
   $stmt->bindParam("price",$price);
   $stmt->bindParam("note",$note);
   $stmt->bindParam("unit",$unit);
   $stmt->bindParam("stock",$stock);
   $stmt->bindParam("bond_value",$bond_value);
   $stmt->bindParam("cover_value",$cover_value);
   $stmt->bindParam("handling_type",$handling_type);
   $stmt->bindParam("allowed_credit",$allowed_credit);
   $stmt->bindParam("interest_rate",$interest_rate);
   $stmt->bindParam("offtaker_rate",$offtaker_rate);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success save!";
   $stat[2] =  $stmt->fetchColumn(0);
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function deleteRequest($idrequest)
{
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("delete from m_request where id_request = :id");
   $stmt->bindParam("id",$idrequest);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success Delete!";
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function autoCompleteRequest($term)
{
  $trm = "%".$term."%";
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("SELECT a.* FROM m_request a WHERE  request_name like :term or id_request  like :term order by request_name asc");
   $stmt->bindParam("term",$trm);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}
/*******************************************************************************
 END OF TABEL M_Request
 *******************************************************************************/


/******************************************************************************
    START TABEL m_Loc
    *******************************************************************************/
    public function getListLoc()
    {
      $db = $this->dblocal;
      try
      {
       $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan,t.* FROM m_location t, 
        (SELECT @rownum := 0) r ORDER BY id_loc ASC");
       $stmt->execute();
       $stat[0] = true;
       $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $stat;
     }
     catch(PDOException $ex)
     {
       $stat[0] = false;
       $stat[1] = $ex->getMessage();
       return $stat;
     }
   }

   public function getLoc($id_loc){
    $db = $this->dblocal;
    try
    {
     $stmt = $db->prepare("select a.* from m_location a where a.id_loc = :id ");
     $stmt->bindParam("id",$id_loc);
     $stmt->execute();
     $stat[0] = true;
     $stat[1] = $stmt->fetch(PDO::FETCH_ASSOC);
     return $stat;
   }
   catch(PDOException $ex)
   {
     $stat[0] = false;
     $stat[1] = $ex->getMessage();
     return $stat;
   }
 }


 public function updateLoc($idloc,$loc_name,$cood,$postal,$locality,$state,$country)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_location
    SET  loc_name = UPPER(:loc_name),
    cood= :cood,
    postal= :postal, 
    locality= :locality,
    state= :state, 
    country= :country
    WHERE id_loc= :idloc;");

   $stmt->bindParam("idloc",$idloc);
   $stmt->bindParam("loc_name",$loc_name);
   $stmt->bindParam("cood",$cood);
   $stmt->bindParam("postal",$postal);
   $stmt->bindParam("locality",$locality);
   $stmt->bindParam("state",$state);
   $stmt->bindParam("country",$country);

   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success Edit!";
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function saveLoc($loc_name,$cood,$postal,$locality,$state,$country){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveLoc(:loc_name,:cood,:postal,:locality,:state,:country)");
   $stmt->bindParam("loc_name",$loc_name);
   $stmt->bindParam("cood",$cood);
   $stmt->bindParam("postal",$postal);
   $stmt->bindParam("locality",$locality);
   $stmt->bindParam("state",$state);
   $stmt->bindParam("country",$country);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success save!";
   $stat[2] =  $stmt->fetchColumn(0);

   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function deleteLoc($idloc)
{
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("delete from m_location where id_loc = :id");
   $stmt->bindParam("id",$idloc);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success Delete!";
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function autoCompleteLoc($term)
{
  $trm = "%".$term."%";
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("SELECT a.* FROM m_location a WHERE  loc_name like :term or id_loc  like :term order by loc_name asc");
   $stmt->bindParam("term",$trm);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}
/*******************************************************************************
 END OF TABEL M_loc
 *******************************************************************************/


/******************************************************************************
    START TABEL m_certifier
    *******************************************************************************/
    public function getListCer()
    {
      $db = $this->dblocal;
      try
      {
       $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan,t.* FROM m_certifier t, 
        (SELECT @rownum := 0) r ORDER BY id_cer ASC");
       $stmt->execute();
       $stat[0] = true;
       $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $stat;
     }
     catch(PDOException $ex)
     {
       $stat[0] = false;
       $stat[1] = $ex->getMessage();
       return $stat;
     }
   }

   public function getCer($id_cer){
    $db = $this->dblocal;
    try
    {
     $stmt = $db->prepare("select a.* from m_certifier a where a.id_cer = :id ");
     $stmt->bindParam("id",$id_cer);
     $stmt->execute();
     $stat[0] = true;
     $stat[1] = $stmt->fetch(PDO::FETCH_ASSOC);
     return $stat;
   }
   catch(PDOException $ex)
   {
     $stat[0] = false;
     $stat[1] = $ex->getMessage();
     return $stat;
   }
 }


 public function updateCer($idcer,$cer_name,$loc_name,$commodity)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_certifier
    SET  loc_name = UPPER(:loc_name),
    cer_name = UPPER(:cer_name),
    commodity= :commodity 
    
    WHERE id_cer= :idcer;");

   $stmt->bindParam("idcer",$idcer);
   $stmt->bindParam("loc_name",$loc_name);
   $stmt->bindParam("cer_name",$cer_name);
   $stmt->bindParam("commodity",$commodity);

   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success Edit!";
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function saveCer($cer_name,$loc_name,$commodity){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveCer(:cer_name,:loc_name,:commodity)");
   $stmt->bindParam("cer_name",$cer_name);
   $stmt->bindParam("loc_name",$loc_name);
   $stmt->bindParam("commodity",$commodity);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success save!";
   $stat[2] =  $stmt->fetchColumn(0);

   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function deleteCer($idcer)
{
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("delete from m_certifier where id_cer = :id");
   $stmt->bindParam("id",$idcer);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success Delete!";
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function autoCompleteCer($term)
{
  $trm = "%".$term."%";
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("SELECT a.* FROM m_certifier a WHERE  cer_name like :term or id_cer  like :term order by cer_name asc");
   $stmt->bindParam("term",$trm);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}
/*******************************************************************************
 END OF TABEL M_cer
 *******************************************************************************/




/******************************************************************************
    START TABEL m_offtaker
    *******************************************************************************/
    public function getListOff()
    {
      $db = $this->dblocal;
      try
      {
       $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan,t.* FROM m_offtaker t, 
        (SELECT @rownum := 0) r ORDER BY id_off ASC");
       $stmt->execute();
       $stat[0] = true;
       $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $stat;
     }
     catch(PDOException $ex)
     {
       $stat[0] = false;
       $stat[1] = $ex->getMessage();
       return $stat;
     }
   }

   public function getOff($id_off){
    $db = $this->dblocal;
    try
    {
     $stmt = $db->prepare("select a.* from m_offtaker a where a.id_off = :id ");
     $stmt->bindParam("id",$id_off);
     $stmt->execute();
     $stat[0] = true;
     $stat[1] = $stmt->fetch(PDO::FETCH_ASSOC);
     return $stat;
   }
   catch(PDOException $ex)
   {
     $stat[0] = false;
     $stat[1] = $ex->getMessage();
     return $stat;
   }
 }


 public function updateOff($idoff,$off_name,$loc_name,$receipt_limit,$addressoff,$msisdnoff)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_offtaker
    SET  loc_name = UPPER(:loc_name),
    off_name = UPPER(:off_name),
    receipt_limit= :receipt_limit, 
    addressoff= :addressoff,
    msisdnoff= :msisdnoff  
    
    WHERE id_off= :idoff;");

   $stmt->bindParam("idoff",$idoff);
   $stmt->bindParam("off_name",$off_name);
   $stmt->bindParam("loc_name",$loc_name);
   $stmt->bindParam("receipt_limit",$receipt_limit);
   $stmt->bindParam("addressoff",$addressoff);
   $stmt->bindParam("msisdnoff",$msisdnoff);

   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success Edit!";
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function saveOff($off_name,$loc_name,$receipt_limit,$addressoff,$msisdnoff){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveOff(:off_name,:loc_name,:receipt_limit,:addressoff,:msisdnoff)");
   $stmt->bindParam("off_name",$off_name);
   $stmt->bindParam("loc_name",$loc_name);
   $stmt->bindParam("receipt_limit",$receipt_limit);
   $stmt->bindParam("addressoff",$addressoff);
   $stmt->bindParam("msisdnoff",$msisdnoff);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success save!";
   $stat[2] =  $stmt->fetchColumn(0);

   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function deleteOff($idoff)
{
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("delete from m_offtaker where id_off = :id");
   $stmt->bindParam("id",$idoff);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success Delete!";
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function autoCompleteOff($term)
{
  $trm = "%".$term."%";
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("SELECT a.* FROM m_offtaker a WHERE  off_name like :term or id_off  like :term order by off_name asc");
   $stmt->bindParam("term",$trm);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}
/*******************************************************************************
 END OF TABEL M_Off
 *******************************************************************************/




/******************************************************************************
    START TABEL m_farmer
    *******************************************************************************/
    public function getListFar()
    {
      $db = $this->dblocal;
      try
      {
       $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan,t.* FROM m_farmer t, 
        (SELECT @rownum := 0) r ORDER BY id_far ASC");
       $stmt->execute();
       $stat[0] = true;
       $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $stat;
     }
     catch(PDOException $ex)
     {
       $stat[0] = false;
       $stat[1] = $ex->getMessage();
       return $stat;
     }
   }

   public function getFar($id_far){
    $db = $this->dblocal;
    try
    {
     $stmt = $db->prepare("select a.* from m_farmer a where a.id_far = :id ");
     $stmt->bindParam("id",$id_far);
     $stmt->execute();
     $stat[0] = true;
     $stat[1] = $stmt->fetch(PDO::FETCH_ASSOC);
     return $stat;
   }
   catch(PDOException $ex)
   {
     $stat[0] = false;
     $stat[1] = $ex->getMessage();
     return $stat;
   }
 }


 public function updateFar($idfar,$far_name,$loc_name,$addressfar,$msisdnfar)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_farmer
    SET  loc_name = UPPER(:loc_name),
    far_name = UPPER(:far_name),
    addressfar= :addressfar,
    msisdnfar= :msisdnfar  
    
    WHERE id_far= :idfar;");

   $stmt->bindParam("idfar",$idfar);
   $stmt->bindParam("far_name",$far_name);
   $stmt->bindParam("loc_name",$loc_name);
   $stmt->bindParam("addressfar",$addressfar);
   $stmt->bindParam("msisdnfar",$msisdnfar);

   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success Edit!";
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function saveFar($far_name,$loc_name,$addressfar,$msisdnfar){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveFar(:far_name,:loc_name,:addressfar,:msisdnfar)");
   $stmt->bindParam("far_name",$far_name);
   $stmt->bindParam("loc_name",$loc_name);
   $stmt->bindParam("addressfar",$addressfar);
   $stmt->bindParam("msisdnfar",$msisdnfar);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success save!";
   $stat[2] =  $stmt->fetchColumn(0);

   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function deleteFar($idfar)
{
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("delete from m_farmer where id_far = :id");
   $stmt->bindParam("id",$idfar);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success Delete!";
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function autoCompletefar($term)
{
  $trm = "%".$term."%";
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("SELECT a.* FROM m_farmer a WHERE  far_name like :term or id_far  like :term order by far_name asc");
   $stmt->bindParam("term",$trm);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}
/*******************************************************************************
 END OF TABEL M_farmer
 *******************************************************************************/


 /******************************************************************************
    START TABEL m_p_receipt
    *******************************************************************************/
    public function getListPre()
    {
      $db = $this->dblocal;
      try
      {
       $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan,t.* FROM m_p_receipt t, 
        (SELECT @rownum := 0) r ORDER BY id_pre ASC");
       $stmt->execute();
       $stat[0] = true;
       $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $stat;
     }
     catch(PDOException $ex)
     {
       $stat[0] = false;
       $stat[1] = $ex->getMessage();
       return $stat;
     }
   }

   public function getPre($id_pre){
    $db = $this->dblocal;
    try
    {
     $stmt = $db->prepare("select a.* from m_p_receipt a where a.id_pre = :id ");
     $stmt->bindParam("id",$id_pre);
     $stmt->execute();
     $stat[0] = true;
     $stat[1] = $stmt->fetch(PDO::FETCH_ASSOC);
     return $stat;
   }
   catch(PDOException $ex)
   {
     $stat[0] = false;
     $stat[1] = $ex->getMessage();
     return $stat;
   }
 }


 public function updatePre($idpre,$title,$receipt_identification,$guaranteed_order,$issue_by_offtaker,$issue_to_farmer,$issue_value,$days_of_terms,$commodity_qty)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_p_receipt
    SET  title = :title,
         receipt_identification = :receipt_identification,
         guaranteed_order       = :guaranteed_order,
         issue_by_offtaker      = :issue_by_offtaker,
         issue_to_farmer        = :issue_to_farmer,
         issue_value            = :issue_value,
         days_of_terms          = :days_of_terms,
         commodity_qty          = :commodity_qty

    WHERE id_pre= :idpre;");

   $stmt->bindParam("idpre",$idpre);
   $stmt->bindParam("title",$title);
   $stmt->bindParam("receipt_identification",$receipt_identification);
   $stmt->bindParam("guaranteed_order",$guaranteed_order);
   $stmt->bindParam("issue_by_offtaker",$issue_by_offtaker);
   $stmt->bindParam("issue_to_farmer",$issue_to_farmer);
   $stmt->bindParam("issue_value",$issue_value);
   $stmt->bindParam("days_of_terms",$days_of_terms);
   $stmt->bindParam("commodity_qty",$commodity_qty);
   

   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success Edit!";
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function savePre($title,$receipt_identification,$guaranteed_order,$issue_by_offtaker,$issue_to_farmer,$issue_value,$days_of_terms,$commodity_qty){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call savePre(:title,:receipt_identification,:guaranteed_order,:issue_by_offtaker,:issue_to_farmer,:issue_value,:days_of_terms,:commodity_qty)");
   $stmt->bindParam("title",$title);
   $stmt->bindParam("receipt_identification",$receipt_identification);
   $stmt->bindParam("guaranteed_order",$guaranteed_order);
   $stmt->bindParam("issue_by_offtaker",$issue_by_offtaker);
   $stmt->bindParam("issue_to_farmer",$issue_to_farmer);
   $stmt->bindParam("issue_value",$issue_value);
   $stmt->bindParam("days_of_terms",$days_of_terms);
   $stmt->bindParam("commodity_qty",$commodity_qty);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success save!";
   $stat[2] =  $stmt->fetchColumn(0);

   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function deletePre($idfar)
{
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("delete from m_p_receipt where id_pre = :id");
   $stmt->bindParam("id",$idpre);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success Delete!";
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function autoCompletePre($term)
{
  $trm = "%".$term."%";
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("SELECT a.* FROM m_p_receipt a WHERE  title like :term or id_pre  like :term order by title asc");
   $stmt->bindParam("term",$trm);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}
/*******************************************************************************
 END OF TABEL M_p_receipt
 *******************************************************************************/




/******************************************************************************
    START TABEL m_Cpr
    *******************************************************************************/
    public function getListCpr()
    {
      $db = $this->dblocal;
      try
      {
       $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan,t.* FROM m_certify_receipt t, 
        (SELECT @rownum := 0) r ORDER BY id_cpr ASC");
       $stmt->execute();
       $stat[0] = true;
       $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $stat;
     }
     catch(PDOException $ex)
     {
       $stat[0] = false;
       $stat[1] = $ex->getMessage();
       return $stat;
     }
   }

   public function getCpr($id_cpr){
    $db = $this->dblocal;
    try
    {
     $stmt = $db->prepare("select a.* from m_certify_receipt a where a.id_cpr = :id ");
     $stmt->bindParam("id",$id_cpr);
     $stmt->execute();
     $stat[0] = true;
     $stat[1] = $stmt->fetch(PDO::FETCH_ASSOC);
     return $stat;
   }
   catch(PDOException $ex)
   {
     $stat[0] = false;
     $stat[1] = $ex->getMessage();
     return $stat;
   }
 }


 public function updateCpr($idcpr,$cpr_title,$guaranteed_order,$certify_receipt,$certifier_address,$current_status)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_certify_receipt
    SET  cpr_title = UPPER(:cpr_title),
    guaranteed_order = guaranteed_order,
    certify_receipt= :certify_receipt,
    certifier_address= :certifier_address,
    current_status= :current_status  
    
    WHERE id_cpr= :idcpr;");

   $stmt->bindParam("idcpr",$idcpr);
   $stmt->bindParam("cpr_title",$cpr_title);
   $stmt->bindParam("guaranteed_order",$guaranteed_order);
   $stmt->bindParam("certify_receipt",$certify_receipt);
   $stmt->bindParam("certifier_address",$certifier_address);
   $stmt->bindParam("current_status",$current_status);

   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success Edit!";
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function saveCpr($cpr_title,$guaranteed_order,$certify_receipt,$certifier_address,$current_status){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call savecpr(:cpr_title,:guaranteed_order,:certify_receipt,:certifier_address,:current_status)");
   
   $stmt->bindParam("cpr_title",$cpr_title);
   $stmt->bindParam("guaranteed_order",$guaranteed_order);
   $stmt->bindParam("certify_receipt",$certify_receipt);
   $stmt->bindParam("certifier_address",$certifier_address);
   $stmt->bindParam("current_status",$current_status);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success save!";
   $stat[2] =  $stmt->fetchColumn(0);

   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function deleteCpr($idcpr)
{
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("delete from m_certify_receipt where id_cpr = :id");
   $stmt->bindParam("id",$idcpr);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success Delete!";
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function autoCompletecpr($term)
{
  $trm = "%".$term."%";
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("SELECT a.* FROM m_certify_receipt a WHERE  cpr_title like :term or id_cpr  like :term order by cpr_title asc");
   $stmt->bindParam("term",$trm);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}
/*******************************************************************************
 END OF TABEL m_certify_receipt
 *******************************************************************************/


 /******************************************************************************
    START TABEL m_redeemed
    *******************************************************************************/
    public function getListRpr()
    {
      $db = $this->dblocal;
      try
      {
       $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan,t.* FROM m_redeemed_receipt t, 
        (SELECT @rownum := 0) r ORDER BY id_rpr ASC");
       $stmt->execute();
       $stat[0] = true;
       $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $stat;
     }
     catch(PDOException $ex)
     {
       $stat[0] = false;
       $stat[1] = $ex->getMessage();
       return $stat;
     }
   }

   public function getRpr($id_rpr){
    $db = $this->dblocal;
    try
    {
     $stmt = $db->prepare("select a.* from m_redeemed_receipt a where a.id_rpr = :id ");
     $stmt->bindParam("id",$id_rpr);
     $stmt->execute();
     $stat[0] = true;
     $stat[1] = $stmt->fetch(PDO::FETCH_ASSOC);
     return $stat;
   }
   catch(PDOException $ex)
   {
     $stat[0] = false;
     $stat[1] = $ex->getMessage();
     return $stat;
   }
 }


 public function updateRpr($idrpr,$rpr_title,$guaranteed_order,$redeemed_receipt,$redeemed_address,$current_status)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_redeemed_receipt
    SET  rpr_title = UPPER(:rpr_title),
    guaranteed_order = :guaranteed_order,
    redeemed_receipt=  :redeemed_receipt,
    redeemed_address=  :redeemed_address,
    current_status=    :current_status  
    
    WHERE id_rpr= :idrpr;");

   $stmt->bindParam("idrpr",$idrpr);
   $stmt->bindParam("rpr_title",$rpr_title);
   $stmt->bindParam("guaranteed_order",$guaranteed_order);
   $stmt->bindParam("redeemed_receipt",$redeemed_receipt);
   $stmt->bindParam("redeemed_address",$redeemed_address);
   $stmt->bindParam("current_status",$current_status);

   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success Edit!";
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function saveRpr($rpr_title,$guaranteed_order,$redeemed_receipt,$redeemed_address,$current_status){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveRpr(:rpr_title,:guaranteed_order,:redeemed_receipt,:redeemed_address,:current_status)");
   
   $stmt->bindParam("rpr_title",$rpr_title);
   $stmt->bindParam("guaranteed_order",$guaranteed_order);
   $stmt->bindParam("redeemed_receipt",$redeemed_receipt);
   $stmt->bindParam("redeemed_address",$redeemed_address);
   $stmt->bindParam("current_status",$current_status);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success save!";
   $stat[2] =  $stmt->fetchColumn(0);

   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function deleteRpr($idrpr)
{
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("delete from m_redeemed_receipt where id_rpr = :id");
   $stmt->bindParam("id",$idrpr);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success Delete!";
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function autoCompleteRpr($term)
{
  $trm = "%".$term."%";
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("SELECT a.* FROM m_redeemed_receipt a WHERE  rpr_title like :term or id_rpr  like :term order by rpr_title asc");
   $stmt->bindParam("term",$trm);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}
/*******************************************************************************
 END OF TABEL m_redeemed_receipt
 *******************************************************************************/


 /******************************************************************************
    START TABEL m_funding
    *******************************************************************************/
    public function getListCur()
    {
      $db = $this->dblocal;
      try
      {
       $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan,t.* FROM m_funding t, 
        (SELECT @rownum := 0) r ORDER BY id_cur ASC");
       $stmt->execute();
       $stat[0] = true;
       $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $stat;
     }
     catch(PDOException $ex)
     {
       $stat[0] = false;
       $stat[1] = $ex->getMessage();
       return $stat;
     }
   }

   public function getCur($id_cur){
    $db = $this->dblocal;
    try
    {
     $stmt = $db->prepare("select a.* from m_funding a where a.id_cur = :id ");
     $stmt->bindParam("id",$id_cur);
     $stmt->execute();
     $stat[0] = true;
     $stat[1] = $stmt->fetch(PDO::FETCH_ASSOC);
     return $stat;
   }
   catch(PDOException $ex)
   {
     $stat[0] = false;
     $stat[1] = $ex->getMessage();
     return $stat;
   }
 }


 public function updateCur($idcur,$cur_name,$currency_type,$amount,$addresscur,$msisdncur)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_funding
    SET  cur_name = UPPER(:cur_name,
    currency_type = :currency_type,
    amount=         :amount,
    addresscur=     :addresscur,
    msisdncur=      :msisdncur  
    
    WHERE id_cur= :idcur;");

   $stmt->bindParam("idcur",$idcur);
   $stmt->bindParam("cur_name",$cur_name);
   $stmt->bindParam("currency_type",$currency_type);
   $stmt->bindParam("amount",$amount);
   $stmt->bindParam("addresscur",$addresscur);
   $stmt->bindParam("msisdncur",$msisdncur);

   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success Edit!";
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function saveCur($cur_name,$currency_type,$amount,$addresscur,$msisdncur){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveCur(:cur_name,:currency_type,:amount,:addresscur,:msisdncur)");
   
    $stmt->bindParam("cur_name",$cur_name);
   $stmt->bindParam("currency_type",$currency_type);
   $stmt->bindParam("amount",$amount);
   $stmt->bindParam("addresscur",$addresscur);
   $stmt->bindParam("msisdncur",$msisdncur);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success save!";
   $stat[2] =  $stmt->fetchColumn(0);

   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function deleteCur($idcur)
{
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("delete from m_funding where id_cur = :id");
   $stmt->bindParam("id",$idcur);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = "Success Delete!";
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}

public function autoCompleteCur($term)
{
  $trm = "%".$term."%";
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("SELECT a.* FROM m_funding a WHERE  cur_name like :term or id_cur  like :term order by cur_name asc");
   $stmt->bindParam("term",$trm);
   $stmt->execute();
   $stat[0] = true;
   $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
   return $stat;
 }
 catch(PDOException $ex)
 {
   $stat[0] = false;
   $stat[1] = $ex->getMessage();
   return $stat;
 }
}
/*******************************************************************************
 END OF TABEL m_funding
 *******************************************************************************/




 /******************************************************************************
   TABEL T_JUAL AND TEMP_JUAL
 *******************************************************************************/
   public function deleteTempSaleByUser($iduser)
   {
    $db = $this->dblocal;
    try
    {
      $stmt = $db->prepare("delete from temp_sale where id_user = :id");
      $stmt->bindParam("id",$iduser);
      $stmt->execute();
      $stat[0] = true;
      $stat[1] = "Success Delete!";
      return $stat;
    }
    catch(PDOException $ex)
    {
      $stat[0] = false;
      $stat[1] = $ex->getMessage();
      return $stat;
    }
  }
  public function resetTempSaleByUserSession($iduser,$uniqid)
  {
    $db = $this->dblocal;
    try
    {
      $stmt = $db->prepare("delete from temp_sale where id_user = :id and uniqid = :uniqid");
      $stmt->bindParam("id",$iduser);
      $stmt->bindParam("uniqid",$uniqid);
      $stmt->execute();
      $stat[0] = true;
      $stat[1] = "Success Delete!";
      return $stat;
    }
    catch(PDOException $ex)
    {
      $stat[0] = false;
      $stat[1] = $ex->getMessage();
      return $stat;
    }
  }
  public function getListTempSale($cashier,$uniqid){
    $db = $this->dblocal;
    try
    {
      $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan,t.*
        FROM temp_sale t, 
        (SELECT @rownum := 0) r where t.id_user= :cashier and t.uniqid= :uniqid  ORDER BY input_date ASC");
      $stmt->bindParam("cashier",$cashier);
      $stmt->bindParam("uniqid",$uniqid);
      $stmt->execute();
      $stat[0] = true;
      $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $stat;
    }
    catch(PDOException $ex)
    {
      $stat[0] = false;
      $stat[1] = $ex->getMessage();
      return $stat;
    }
  }


  public function deleteTempSaleProduct($cashier,$uniqid,$id_item)
  {
   $db = $this->dblocal;
   try
   {
    $stmt = $db->prepare("delete from temp_sale where id_user = :id and uniqid = :uniqid and id_item = :id_item ");
    $stmt->bindParam("id",$cashier);
    $stmt->bindParam("uniqid",$uniqid);
    $stmt->bindParam("id_item",$id_item);
    $stmt->execute();
    $stat[0] = true;
    $stat[1] = "Success Delete!";
    return $stat;
  }
  catch(PDOException $ex)
  {
    $stat[0] = false;
    $stat[1] = $ex->getMessage();
    return $stat;
  }
}

public function updateTempSale($cashier,$uniqid,$id_item)
{
  $db = $this->dblocal;
  try
  {
    $stmt = $db->prepare("update temp_sale set qty=qty+1 where uniqid= :uniqid and id_user = :cashier 
      and id_item = :id_item ");

    $stmt->bindParam("cashier",$cashier);
    $stmt->bindParam("uniqid",$uniqid);
    $stmt->bindParam("id_item",$id_item);

    $stmt->execute();
    $stat[0] = true;
    $stat[1] = "Success Edit!";
    return $stat;
  }
  catch(PDOException $ex)
  {
    $stat[0] = false;
    $stat[1] = $ex->getMessage();
    return $stat;
  }
}
public function updateTempSaleHargaSale($cashier,$uniqid,$id_item,$value)
{
  $db = $this->dblocal;
  try
  {
    $stmt = $db->prepare("update temp_sale set price = :value
      where uniqid= :uniqid and id_user = :cashier 
      and id_item = :id_item ");

    $stmt->bindParam("cashier",$cashier);
    $stmt->bindParam("uniqid",$uniqid);
    $stmt->bindParam("id_item",$id_item);
    $stmt->bindParam("value",$value);

    $stmt->execute();
    $stat[0] = true;
    $stat[1] = "Sukses Ubah!";
    return $stat;
  }
  catch(PDOException $ex)
  {
    $stat[0] = false;
    $stat[1] = $ex->getMessage();
    return $stat;
  }
}
public function updateTempSaleQty($cashier,$uniqid,$id_item ,$value)
{
  $db = $this->dblocal;
  try
  {
    $stmt = $db->prepare("update temp_sale set qty= :value where uniqid= :uniqid and id_user = :cashier 
      and id_item = :id_item ");

    $stmt->bindParam("cashier",$cashier);
    $stmt->bindParam("uniqid",$uniqid);
    $stmt->bindParam("id_item",$id_item);
    $stmt->bindParam("value",$value);

    $stmt->execute();
    $stat[0] = true;
    $stat[1] = "Success Edit!";
    return $stat;
  }
  catch(PDOException $ex)
  {
    $stat[0] = false;
    $stat[1] = $ex->getMessage();
    return $stat;
  }
}
public function deleteSale($sale_id,$note)
{
  $db = $this->dblocal;
  try
  {
    $stmt = $db->prepare("call deleteSale(:id,:note)");
    $stmt->bindParam("id",$sale_id);
    $stmt->bindParam("note",$note);
    $stmt->execute();
    $stat[0] = true;
    $stat[1] = 'Success Delete';
    return $stat;
  }
  catch(PDOException $ex)
  {
    $stat[0] = false;
    $stat[1] = $ex->getMessage();
    return $stat;
  }
}
public function updateTempSaleDisc($cashier,$uniqid,$id_item,$value)
{
  $db = $this->dblocal;
  try
  {
    $stmt = $db->prepare("update temp_sale set discprc = :value
      where uniqid= :uniqid and id_user = :cashier 
      and id_item = :id_item ");

    $stmt->bindParam("cashier",$cashier);
    $stmt->bindParam("uniqid",$uniqid);
    $stmt->bindParam("id_item",$id_item);
    $stmt->bindParam("value",$value);

    $stmt->execute();
    $stat[0] = true;
    $stat[1] = "Success Edit!";
    return $stat;
  }
  catch(PDOException $ex)
  {
    $stat[0] = false;
    $stat[1] = $ex->getMessage();
    return $stat;
  }
}

public function saveTempSale($cashier,$uniqid,$id_item,$unit,$item_name,$qty,$price,$discprn,$discrp)
{
  $db = $this->dblocal;
  try
  {
    $stmt = $db->prepare("insert into temp_sale(id_user, uniqid, id_item, item_name, qty, unit, price, discprc, discrp) values 
      (:cashier , :uniqid , :id_item, :item_name, :qty, :unit, :price, :discprn, :discrp)");
    $stmt->bindParam("cashier",$cashier);
    $stmt->bindParam("uniqid",$uniqid);
    $stmt->bindParam("id_item",$id_item);
    $stmt->bindParam("unit",$unit);
    $stmt->bindParam("item_name",$item_name);
    $stmt->bindParam("qty",$qty);
    $stmt->bindParam("price",$price);
    $stmt->bindParam("discprn",$discprn);
    $stmt->bindParam("discrp",$discrp);

    $stmt->execute();
    $stat[0] = true;
    $stat[1] = "Success save!";
    return $stat;
  }
  catch(PDOException $ex)
  {
    $stat[0] = false;
    $stat[1] = $ex->getMessage();
    return $stat;
  }
}
public function saveSale($sale_id,$sale_date,$paid,$disc_prcn,$disc_rp,$uniqid,$id_user,$note)
{
  $db = $this->dblocal;
  try
  {
    $stmt = $db->prepare("call saveSale( :sale_id, :sale_date, :paid, :disc_prcn,
     :disc_rp, :uniqid, :id_user, :note)");
    $stmt->bindParam("sale_id",$sale_id);
    $stmt->bindParam("sale_date",$sale_date);
    $stmt->bindParam("paid",$paid);
    $stmt->bindParam("disc_prcn",$disc_prcn);
    $stmt->bindParam("disc_rp",$disc_rp);
    $stmt->bindParam("uniqid",$uniqid);
    $stmt->bindParam("id_user",$id_user);
    $stmt->bindParam("note",$note);
    $stmt->execute();
    $stat[0] = true;
    $stat[1] = "Success Save!";
    $stat[2] =  $stmt->fetchColumn(0);
    return $stat;
  }
  catch(PDOException $ex)
  {
    $stat[0] = false;
    $stat[1] = $ex->getMessage();
    return $stat;
  }
}
public function getSubTotalTempSale($cashier,$uniqid){
  $db = $this->dblocal;
  try
  {
    $stmt = $db->prepare("SELECT SUM((price - (price*(discprc/100)))*qty)AS total 
      FROM temp_sale where uniqid= :uniqid and id_user = :cashier");
    $stmt->bindParam("cashier",$cashier);
    $stmt->bindParam("uniqid",$uniqid);
    $stmt->execute();
    $stat[0] = true;
    $stat[1] = $stmt->fetchColumn(0);
    $stat[2] = $stmt->rowCount();
    return $stat;
  }
  catch(PDOException $ex)
  {
    $stat[0] = false;
    $stat[1] = $ex->getMessage();
    return $stat;
  }
}
public function checkTempSale($cashier,$uniqid){
  $db = $this->dblocal;
  try
  {
    $stmt = $db->prepare("SELECT id_user,uniqid FROM temp_sale where uniqid= :uniqid and id_user = :cashier");
    $stmt->bindParam("cashier",$cashier);
    $stmt->bindParam("uniqid",$uniqid);
    $stmt->execute();
    $stat[0] = true;
    $stat[1] = $stmt->rowCount();
    return $stat;
  }
  catch(PDOException $ex)
  {
    $stat[0] = false;
    $stat[1] = $ex->getMessage();
    return $stat;
  }
}

public function getCheckProduk($cashier,$uniqid,$id_item ){
  $db = $this->dblocal;
  try
  {
    $stmt = $db->prepare("select * from temp_sale where uniqid= :uniqid and id_user = :cashier and id_item = :id_item");
    $stmt->bindParam("cashier",$cashier);
    $stmt->bindParam("uniqid",$uniqid);
    $stmt->bindParam("id_item",$id_item);
    $stmt->execute();
    $stat[0] = true;
    $stat[1] = $stmt->rowCount();
    return $stat;
  }
  catch(PDOException $ex)
  {
    $stat[0] = false;
    $stat[1] = $ex->getMessage();
    return $stat;
  }
}


public function getTransSale($awal,$akhir,$order = 'desc')
{
 $db = $this->dblocal;
 try
 {
  $stmt = $db->prepare("SELECT  a.`sale_date`,a.`sale_id`,
    (SELECT SUM((d.price - (d.price*(d.disc_prc/100)))*d.qty) AS total
    FROM t_sale_detail d WHERE d.sale_id = a.sale_id)AS total,
    c.`username`,a.sts,a.paid,a.disc_rp
    FROM t_sale a 
    INNER JOIN m_user c ON a.`id_user` = c.`id_user`
    where (a.`sale_date` BETWEEN :awal AND :akhir)
    ORDER BY sale_id ".$order );
  $stmt->bindParam("awal",$awal);
  $stmt->bindParam("akhir",$akhir);
  $stmt->execute();
  $stat[0] = true;
  $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $stat;
}
catch(PDOException $ex)
{
  $stat[0] = false;
  $stat[1] = $ex->getMessage();
  return $stat;
}
}


public function getSaleId($id){
  $db = $this->dblocal;
  try
  {
    $stmt = $db->prepare("SELECT a.* ,c.`username`
      FROM t_sale a 
      INNER JOIN m_user c ON a.`id_user` = c.`id_user` where a.sale_id = :id");
    $stmt->bindParam("id",$id);
    $stmt->execute();
    $stat[0] = true;
    $stat[1] = $stmt->fetch(PDO::FETCH_ASSOC);
    return $stat;
  }
  catch(PDOException $ex)
  {
    $stat[0] = false;
    $stat[1] = $ex->getMessage();
    return $stat;
  }
}

public function getSaleDetailIdSale($id)
{
  $db = $this->dblocal;
  try
  {
    $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan, a.*,
      (a.price - ((a.price * a.disc_prc) /100) ) * a.qty as total 
      from t_sale_detail a,(SELECT @rownum := 0) r  where a.sale_id = :id");
    $stmt->bindParam("id",$id);
    $stmt->execute();
    $stat[0] = true;
    $stat[1] = $stmt->fetchall(PDO::FETCH_ASSOC);
    return $stat;
  }
  catch(PDOException $ex)
  {
    $stat[0] = false;
    $stat[1] = $ex->getMessage();
    return $stat;
  }
}

 /******************************************************************************
    END TABEL T_JUAL
 *******************************************************************************/


 /******************************************************************************
    START OF pos MENU CODE
 *******************************************************************************/
    public function getMenu()
    {
    	$db = $this->dblocal;
    	try
    	{
    		$stmt = $db->prepare("select * from r_menu order by menu_order");
    		$stmt->execute();
    		$stat[0] = true;
        $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    		return $stat;
    	}
    	catch(PDOException $ex)
    	{
    		$stat[0] = false;
    		$stat[1] = $ex->getMessage();
    		return $stat;
    	}
    }

    
    public function getSubMenu($id)
    {
    	$db = $this->dblocal;
    	try
    	{
    		$stmt = $db->prepare("select * from r_menu_sub where id_menu = :id order by sub_menu_order asc");
    		$stmt->bindParam("id",$id);
    		$stmt->execute();
    		$stat[0] = true;
        $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //$stat[2] = $stmt->rowCount();
    		return $stat;
    	}
    	catch(PDOException $ex)
    	{
    		$stat[0] = false;
    		$stat[1] = $ex->getMessage();
    		return $stat;
    	}
    }



    /*********************query for system*********************/
    public function getLogin($user,$pass)
    {
     $db = $this->dblocal;
     try
     {
      $stmt = $db->prepare("select a.*,
        (select name_shop from r_ref_system where id = 1) as name_shop,
        (select address_shop from r_ref_system where id = 1) as address_shop,
        (select phone_shop from r_ref_system where id = 1) as phone_shop
        from m_user a where  upper(a.username)=upper(:user) and a.pass_user=md5(:id)");
      $stmt->bindParam("user",$user);
      $stmt->bindParam("id",$pass);
      $stmt->execute();
      $stat[0] = true;
      $stat[1] = $stmt->fetch(PDO::FETCH_ASSOC);
      $stat[2] = $stmt->rowCount();
      return $stat;
    }
    catch(PDOException $ex)
    {
      $stat[0] = false;
      $stat[1] = $ex->getMessage();
      $stat[2] = 0;
      return $stat;
    }
  }

  public function getrefsytem()
  {
    $db = $this->dblocal;
    try
    {
      $stmt = $db->prepare("select a.* from r_ref_system a where id = 1 ");
      $stmt->execute();
      $stat[0] = true;
      $stat[1] = $stmt->fetch(PDO::FETCH_ASSOC);
      return $stat;
    }
    catch(PDOException $ex)
    {
      $stat[0] = false;
      $stat[1] = $ex->getMessage();
      $stat[2] = 0;
      return $stat;
    }
  }
  public function getblockadd($uname)
  {
    $db = $this->dblocal;
    try
    {
      $stmt = $db->prepare("select wphone,b_address,b_token from m_user a where username = :uname");
      $stmt->bindParam("uname",$uname);
      $stmt->execute();
      $stat[0] = true;
      $stat[1] = $stmt->fetch(PDO::FETCH_ASSOC);
      return $stat;
    }
    catch(PDOException $ex)
    {
      $stat[0] = false;
      $stat[1] = $ex->getMessage();
      $stat[2] = 0;
      return $stat;
    }
  }
  public function getSubMenuById($menu)
  {
    $db = $this->dblocal;
    try
    {
      $stmt = $db->prepare("SELECT name_sub_menu FROM r_menu_sub WHERE id_sub_menu= :menu");

      $stmt->bindParam("menu",$menu);
      $stmt->execute();
      $stat[0] = true;
      $stat[1] = $stmt->fetchColumn(0);
      $stat[2] = $stmt->rowCount();
      return $stat;
    }
    catch(PDOException $ex)
    {
      $stat[0] = false;
      $stat[1] = $ex->getMessage();
      return $stat;
    }
  }
  public function updateUniqLogin($id_user,$uniq_login)
  {
    $db = $this->dblocal;
    try
    {
      $stmt = $db->prepare("update m_user set uniq_login = :uniq_login where id_user = :id_user");

      $stmt->bindParam("id_user",$id_user);
      $stmt->bindParam("uniq_login",$uniq_login);

      $stmt->execute();
      $stat[0] = true;
      $stat[1] = "Sukses Ubah!";
      return $stat;
    }
    catch(PDOException $ex)
    {
      $stat[0] = false;
      $stat[1] = $ex->getMessage();
      return $stat;
    }
  }

  /*********************query for master user*********************/
  public function getListUser()
  {
    $db = $this->dblocal;
    try
    {
      $stmt = $db->prepare("select * from m_user where username<>'admin' order by username desc");
      $stmt->execute();
      $stat[0] = true;
      $stat[1] = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $stat;
    }
    catch(PDOException $ex)
    {
      $stat[0] = false;
      $stat[1] = $ex->getMessage();
      return $stat;
    }
  }

  public function saveUser($username,$pass_user,$h_menu)
  {
    $db = $this->dblocal;
    try
    {
      $stmt = $db->prepare("insert into m_user(username,pass_user,h_menu)
        values(:name,MD5(:pass),:hmenu)");

      $stmt->bindParam("name",$username);
      $stmt->bindParam("pass",$pass_user);
      $stmt->bindParam("hmenu",$h_menu);
      $stmt->execute();
      $stat[0] = true;
      $stat[1] = "Sukses save!";
      return $stat;
    }
    catch(PDOException $ex)
    {
      $stat[0] = false;
      $stat[1] = $ex->getMessage();
      return $stat;
    }
  }
  public function updateUser($id_user,$username,$h_menu)
  {
    $db = $this->dblocal;
    try
    {
      $stmt = $db->prepare("update m_user set username = :name, h_menu = :hmenu  where id_user = :id");

      $stmt->bindParam("name",$username);
      $stmt->bindParam("id",$id_user);
      $stmt->bindParam("hmenu",$h_menu);
      $stmt->execute();
      $stat[0] = true;
      $stat[1] = "Sukses update!";
      return $stat;
    }
    catch(PDOException $ex)
    {
      $stat[0] = false;
      $stat[1] = $ex->getMessage();
      return $stat;
    }
  }
  public function deleteUser($id_user)
  {
    $db = $this->dblocal;
    try
    {
      $stmt = $db->prepare("delete from m_user  where id_user = :id");

      $stmt->bindParam("id",$id_user);
      $stmt->execute();
      $stat[0] = true;
      $stat[1] = "Sukses update!";
      return $stat;
    }
    catch(PDOException $ex)
    {
      $stat[0] = false;
      $stat[1] = $ex->getMessage();
      return $stat;
    }
  }

  public function checkPassword($id,$pass)
  {
    $db = $this->dblocal;
    try
    {
      $stmt = $db->prepare("select * from m_user where id_user = :id and pass_user = md5(:pass)");

      $stmt->bindParam("id",$id);
      $stmt->bindParam("pass",$pass);

      $stmt->execute();
      $stat[0] = true;
      $stat[1] = $stmt->rowCount();
      return $stat;
    }
    catch(PDOException $ex)
    {
      $stat[0] = false;
      $stat[1] = $ex->getMessage();
      return $stat;
    }
  }

  public function resetPass($iduser,$pass)
  {
    $db = $this->dblocal;
    try
    {
      $stmt = $db->prepare("update m_user set pass_user = md5(:pass) where id_user=:id");

      $stmt->bindParam("id",$iduser);
      $stmt->bindParam("pass",$pass);
      $stmt->execute();
      $stat[0] = true;
      $stat[1] = "Sukses reset pass!";
      return $stat;
    }
    catch(PDOException $ex)
    {
      $stat[0] = false;
      $stat[1] = $ex->getMessage();
      return $stat;
    }
  }



  /******************************************************************************
    END OF MENU CODE
  *******************************************************************************/
  }

  ?>
