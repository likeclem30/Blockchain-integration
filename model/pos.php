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

public function saveItem($item_name,$loc,$unit,$stock,$terms,$price,$fprice,$note,$response,$loci2){
  $db = $this->dblocal;

  try
  {
   $stmt = $db->prepare("call saveItem(:item_name,:loc,:unit,:stock,:terms,:price,:fprice,:note,:response,:loci2)");
   $stmt->bindParam("item_name",$item_name);
   $stmt->bindParam("loc",$loc);
   $stmt->bindParam("unit",$unit);
   $stmt->bindParam("stock",$stock);
   $stmt->bindParam("terms",$terms);
   $stmt->bindParam("price",$price);
   $stmt->bindParam("fprice",$fprice);
   $stmt->bindParam("note",$note);
   $stmt->bindParam("response",$response);
   $stmt->bindParam("loci2",$loci2);
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
    START TABEL m_agloan
    *******************************************************************************/
    public function getListAgloan()
    {
      $db = $this->dblocal;
      try
      {
       $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan,t.* FROM m_agloan t, 
        (SELECT @rownum := 0) r ORDER BY id_agloan ASC");
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

   public function getAgloan($id_agloan){
    $db = $this->dblocal;
    try
    {
     $stmt = $db->prepare("select a.* from m_agloan a where a.id_agloan = :id ");
     $stmt->bindParam("id",$id_agloan);
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

                                      //$agloan_name,$transaction_type,$principal,$principal_limit,$term,$moratorium,$expenses,$irate,$late_pen,$autopay,$payday,$lonmsisdnagloan,$laddr,$benmsisdnagloan,$baddr,$out,$outgdr,$outgac,$outdesc,$outtran
 public function updateAgloan($idagloan,$agloan_name,$transaction_type,$principal,$principal_limit,$term,$moratorium,$expenses,$irate,$late_pen,$autopay,$payday,$lonmsisdnagloan,$laddr,$benmsisdnagloan,$baddr)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_agloan 
    SET  agloan_name = : agloan_name,
   transaction_type = : transaction_type,
   principal = : principal,
   principal_limit = : principal_limit,
   term = : term,
   moratorium = : moratorium,
   expenses = : expenses,
   irate = : irate,
   late_pen = : late_pen,
   autopay = : autopay,
   payday = : payday,
   
   lonmsisdnagloan = : lonmsisdnagloan,
   lonaddressagloan = : lonaddressagloan,
   benmsisdnagloan = : benmsisdnagloan,
   benaddressagloan = : benaddressagloan
    WHERE id_agloan= :idagloan;");

   $stmt->bindParam("idagloan",$idagloan);
   $stmt->bindParam("agloan_name",$agloan_name);
   $stmt->bindParam("transaction_type",$transaction_type);
   $stmt->bindParam("principal",$principal);
   $stmt->bindParam("principal_limit",$principal_limit);
   $stmt->bindParam("term",$term);
   $stmt->bindParam("moratorium",$moratorium);
   $stmt->bindParam("expenses",$expenses);
   $stmt->bindParam("irate",$irate);
   $stmt->bindParam("late_pen",$late_pen);
   $stmt->bindParam("autopay",$autopay);
   $stmt->bindParam("payday",$payday);
   //$stmt->bindParam("description",$description);
   $stmt->bindParam("lonmsisdnagloan",$lonmsisdnagloan);
   $stmt->bindParam("laddr",$laddr);
   $stmt->bindParam("benmsisdnagloan",$benmsisdnagloan);
   $stmt->bindParam("baddr",$baddr);
   
   
  
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
                         //$agloan_name,$transaction_type,$principal,$principal_limit,$term,$moratorium,$expenses,$irate,$late_pen,$autopay,$payday,$lonmsisdnagloan,$laddr,$benmsisdnagloan,$baddr,$out,$outgdr,$outgac,$outdesc,$outtran
public function saveAgloan($agloan_name,$transaction_type,$principal,$principal_limit,$term,$moratorium,$expenses,$irate,$late_pen,$autopay,$payday,$lonmsisdnagloan,$laddr,$benmsisdnagloan,$baddr,$out,$outgdr,$outgac,$outdesc,$outtran,$address2){  
  $db = $this->dblocal;

  try
  {                                    //$agloan_name,$transaction_type,$principal,$principal_limit,$term,$moratorium,$expenses,$irate,$late_pen,$autopay,$payday,$lonmsisdnagloan,$laddr,$benmsisdnagloan,$baddr,$out,$outgdr,$outgac,$outdesc,$outtran
   $stmt = $db->prepare("call saveAgloan(:agloan_name,:transaction_type,:principal,:principal_limit,:term,:moratorium,:expenses,:irate,:late_pen,:autopay,:payday,:lonmsisdnagloan,:laddr,:benmsisdnagloan,:baddr,:out,:outgdr,:outgac,:outdesc,:outtran,:address2)");
    $stmt->bindParam("agloan_name",$agloan_name);
   $stmt->bindParam("transaction_type",$transaction_type);
   $stmt->bindParam("principal",$principal);
   $stmt->bindParam("principal_limit",$principal_limit);
   $stmt->bindParam("term",$term);
   $stmt->bindParam("moratorium",$moratorium);
   $stmt->bindParam("expenses",$expenses);
   $stmt->bindParam("irate",$irate);
   $stmt->bindParam("late_pen",$late_pen);
   $stmt->bindParam("autopay",$autopay);
   $stmt->bindParam("payday",$payday);
   //$stmt->bindParam("description",$description);
   $stmt->bindParam("lonmsisdnagloan",$lonmsisdnagloan);
   $stmt->bindParam("laddr",$laddr);
   $stmt->bindParam("benmsisdnagloan",$benmsisdnagloan);
   $stmt->bindParam("baddr",$baddr);
   //$out,$outgdr,$outgac,$outdesc,$outtran
   $stmt->bindParam("out",$out);
    $stmt->bindParam("outgdr",$outgdr);
     $stmt->bindParam("outgac",$outgac);
      $stmt->bindParam("outdesc",$outdesc);
       $stmt->bindParam("outtran",$outtran);
       $stmt->bindParam("address2",$address2);
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

public function deleteAgloan($idagloan)
{
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("delete from m_agloan where id_agloan = :id");
   $stmt->bindParam("id",$idagloan);
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

public function autoCompleteAgloan($term)
{
  $trm = "%".$term."%";
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("SELECT a.* FROM m_agloan a WHERE  agloan_name like :term or id_agloan  like :term order by agloan_name asc");
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
 END OF TABEL m_agloan
 *******************************************************************************/

/******************************************************************************
    START TABEL m_expenses
    *******************************************************************************/
    public function getListExp()
    {
      $db = $this->dblocal;
      try
      {
       $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan,t.* FROM m_expenses t, 
        (SELECT @rownum := 0) r ORDER BY id_exp ASC");
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

   public function getExp($id_exp){
    $db = $this->dblocal;
    try
    {
     $stmt = $db->prepare("select a.* from m_expenses a where a.id_exp = :id ");
     $stmt->bindParam("id",$id_exp);
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


 public function updateExp($idexp,$exp_name,$loc,$unit,$terms,$price,$wprice)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_expenses 
    SET  exp_name = UPPER(:exp_name),
    loc = UPPER(:loc),
    unit= :unit,
    terms= :terms,
    price= :price,
    wprice= :wprice
    WHERE id_exp= :idexp;");

   $stmt->bindParam("idexp",$idexp);
   $stmt->bindParam("exp_name",$exp_name);
   $stmt->bindParam("loc",$loc);
   $stmt->bindParam("unit",$unit);
   $stmt->bindParam("terms",$terms);
   $stmt->bindParam("price",$price);
   $stmt->bindParam("wprice",$wprice);
  
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

public function saveExp($exp_name,$loc,$unit,$terms,$price,$wprice,$response,$expindex){
  $db = $this->dblocal;

  try
  {
   $stmt = $db->prepare("call saveExp(:exp_name,:loc,:unit,:terms,:price,:wprice,:response,:expindex)");
   $stmt->bindParam("exp_name",$exp_name);
   $stmt->bindParam("loc",$loc);
   $stmt->bindParam("unit",$unit);
   $stmt->bindParam("terms",$terms);
   $stmt->bindParam("price",$price);
   $stmt->bindParam("wprice",$wprice);
   $stmt->bindParam("response",$response);
   $stmt->bindParam("expindex",$expindex);
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

public function deleteExp($idexp)
{
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("delete from m_expenses where id_exp = :id");
   $stmt->bindParam("id",$idexp);
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

public function autoCompleteExp($term)
{
  $trm = "%".$term."%";
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("SELECT a.* FROM m_expenses a WHERE  exp_name like :term or id_exp  like :term order by exp_name asc");
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
 END OF TABEL m_expenses
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


 public function updateRequest($idrequest,$request_name,$commodity,$stock,$unit,$price,$allowed_credit,$cover_value,$bond_value,$handling_type,$interest_rate,$offtaker_rate,$duration,$msisdnreq,$addressreq,$passreq)
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
    duration= :duration, 
    msisdnreq= :msisdnreq, 
    addressreq= :addressreq, 
    passreq= :passreq
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
   $stmt->bindParam("duration",$duration);
   $stmt->bindParam("msisdnreq",$msisdnreq);
   $stmt->bindParam("addressreq",$addressreq);
   $stmt->bindParam("passreq",$passreq);

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

public function saveRequest($request_name,$commodity,$stock,$unit,$price,$allowed_credit,$cover_value,$bond_value,$handling_type,$interest_rate,$offtaker_rate,$duration,$msisdnreq,$addressreq,$passreq,$address2,$out,$outgdr,$outgac,$outtran){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveRequest(:request_name,:commodity,:stock,:unit,:price,:allowed_credit,:cover_value,:bond_value,:handling_type,:interest_rate,:offtaker_rate,:duration,:msisdnreq,:addressreq,:passreq,:address2,:out,:outgdr,:outgac,:outtran)");
   $stmt->bindParam("request_name",$request_name);
   $stmt->bindParam("commodity",$commodity);
   $stmt->bindParam("price",$price);
   $stmt->bindParam("duration",$duration);
   $stmt->bindParam("unit",$unit);
   $stmt->bindParam("stock",$stock);
   $stmt->bindParam("bond_value",$bond_value);
   $stmt->bindParam("cover_value",$cover_value);
   $stmt->bindParam("handling_type",$handling_type);
   $stmt->bindParam("allowed_credit",$allowed_credit);
   $stmt->bindParam("interest_rate",$interest_rate);
   $stmt->bindParam("offtaker_rate",$offtaker_rate);
   $stmt->bindParam("msisdnreq",$msisdnreq);
   $stmt->bindParam("addressreq",$addressreq);
   $stmt->bindParam("passreq",$passreq);
   $stmt->bindParam("address2",$address2);
   $stmt->bindParam("out",$out);
   $stmt->bindParam("outgdr",$outgdr);
   $stmt->bindParam("outgac",$outgac);
   $stmt->bindParam("outtran",$outtran);


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
    cood=     :cood,
    postal=   :postal, 
    locality= :locality,
    state=    :state, 
    country=  :country
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

public function saveLoc($loc_name,$cood,$postal,$locality,$state,$country,$response,$response2){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveLoc2(:loc_name,:cood,:postal,:locality,:state,:country,:response,:response2)");
   $stmt->bindParam("loc_name",$loc_name);
   $stmt->bindParam("cood",$cood);
   $stmt->bindParam("postal",$postal);
   $stmt->bindParam("locality",$locality);
   $stmt->bindParam("state",$state);
   $stmt->bindParam("country",$country);
   $stmt->bindParam("response",$response);
   $stmt->bindParam("response2",$response2);
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


 public function updateCer($idcer,$cer_name,$loc_name,$commodity,$prate,$frate,$msisdncer,$addresscer)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_certifier
    SET  loc_name = UPPER(:loc_name),
    cer_name = UPPER(:cer_name),
    commodity= :commodity,
    prate = :prate,
    frate = :frate,
    msisdncer= :msisdncer ,
    addresscer= :addresscer  
    
    WHERE id_cer= :idcer;");

   $stmt->bindParam("idcer",$idcer);
   $stmt->bindParam("loc_name",$loc_name);
   $stmt->bindParam("cer_name",$cer_name);
   $stmt->bindParam("commodity",$commodity);
   $stmt->bindParam("prate",$prate);
   $stmt->bindParam("frate",$frate);
   $stmt->bindParam("msisdncer",$msisdncer);
   $stmt->bindParam("addresscer",$addresscer);


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

public function saveCer($cer_name,$loc_name,$commodity,$prate,$frate,$msisdncer,$addresscer,$out){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveCer(:cer_name,:loc_name,:commodity,:prate,:frate,:msisdncer,:addresscer,:out)");
   $stmt->bindParam("cer_name",$cer_name);
   $stmt->bindParam("loc_name",$loc_name);
   $stmt->bindParam("commodity",$commodity);
   $stmt->bindParam("prate",$prate);
   $stmt->bindParam("frate",$frate);
   $stmt->bindParam("msisdncer",$msisdncer);
   $stmt->bindParam("addresscer",$addresscer);
   $stmt->bindParam("out",$out);
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


 public function updateOff($idoff,$off_name,$loc_name,$receipt_limit,$frate,$prate,$transaction_type,$generic_role_type,$addressoff,$msisdnoff)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_offtaker
    SET  loc_name = UPPER(:loc_name),
    off_name = UPPER(:off_name),
    receipt_limit= :receipt_limit, 
    frate= :frate,
    prate= :prate,
    transaction_type= :transaction_type,
    generic_role_type= :generic_role_type,
    addressoff= :addressoff,
    msisdnoff= :msisdnoff  
    
    WHERE id_off= :idoff;");

   $stmt->bindParam("idoff",$idoff);
   $stmt->bindParam("off_name",$off_name);
   $stmt->bindParam("loc_name",$loc_name);
   $stmt->bindParam("receipt_limit",$receipt_limit);
   $stmt->bindParam("frate",$frate);
   $stmt->bindParam("prate",$prate);
   $stmt->bindParam("transaction_type",$transaction_type);
   $stmt->bindParam("generic_role_type",$generic_role_type);
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

public function saveOff($off_name,$loc_name,$receipt_limit,$frate,$prate,$transaction_type,$generic_role_type,$addressoff,$msisdnoff,$out){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveOff(:off_name,:loc_name,:receipt_limit,:frate,:prate,:transaction_type,:generic_role_type,:addressoff,:msisdnoff,:out)");
   $stmt->bindParam("off_name",$off_name);
   $stmt->bindParam("loc_name",$loc_name);
   $stmt->bindParam("receipt_limit",$receipt_limit);
   $stmt->bindParam("frate",$frate);
   $stmt->bindParam("prate",$prate);
   $stmt->bindParam("transaction_type",$transaction_type);
   $stmt->bindParam("generic_role_type",$generic_role_type);
   $stmt->bindParam("addressoff",$addressoff);
   $stmt->bindParam("msisdnoff",$msisdnoff);
   $stmt->bindParam("out",$out);
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


 public function updateFar($idfar,$far_name,$loc_name,$addressfar,$msisdnfar,$transaction_type)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_farmer
    SET  loc_name = UPPER(:loc_name),
    far_name = UPPER(:far_name),
    addressfar= :addressfar,
    msisdnfar= :msisdnfar, 
    transaction_type= :transaction_type  
    
    WHERE id_far= :idfar;");

   $stmt->bindParam("idfar",$idfar);
   $stmt->bindParam("far_name",$far_name);
   $stmt->bindParam("loc_name",$loc_name);
   $stmt->bindParam("addressfar",$addressfar);
   $stmt->bindParam("msisdnfar",$msisdnfar);
   $stmt->bindParam("transaction_type",$transaction_type);

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

public function saveFar($far_name,$loc_name,$addressfar,$msisdnfar,$out,$transaction_type){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveFar(:far_name,:loc_name,:addressfar,:msisdnfar,:out,:transaction_type)");
   $stmt->bindParam("far_name",$far_name);
   $stmt->bindParam("loc_name",$loc_name);
   $stmt->bindParam("addressfar",$addressfar);
   $stmt->bindParam("msisdnfar",$msisdnfar);
   $stmt->bindParam("out",$out);
   $stmt->bindParam("transaction_type",$transaction_type);
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
    START TABEL m_gof
    *******************************************************************************/
    public function getListgof()
    {
      $db = $this->dblocal;
      try
      {
       $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan,t.* FROM m_gof t, 
        (SELECT @rownum := 0) r ORDER BY id_gof ASC");
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

   public function getGof($id_gof){
    $db = $this->dblocal;
    try
    {
     $stmt = $db->prepare("select a.* from m_gof a where a.id_gof = :id ");
     $stmt->bindParam("id",$id_gof);
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


 public function updateGof($idgof,$gof_name,$transaction_type,$msisdngof,$addressgof,$amount,$passgof,$order_address,$off_msisdngof,$off_addressgof)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_gof
    SET  gof_name = UPPER(:gof_name),
     transaction_type= :transaction_type,  
    addressgof     = :addressgof,
    msisdngof      = :msisdngof, 
    amount         = :amount,
    passgof        = :passgof,
    order_address  = :order_address, 
    off_addressgof = :addressgof,
    off_msisdngof  = :msisdngof

   
    
    WHERE id_gof= :idgof;");

   $stmt->bindParam("idgof",$idgof);
   $stmt->bindParam("gof_name",$gof_name);
   $stmt->bindParam("transaction_type",$transaction_type);
   $stmt->bindParam("addressgof",$addressgof);
   $stmt->bindParam("msisdngof",$msisdngof);
   $stmt->bindParam("amount",$amount);
   $stmt->bindParam("passgof",$passgof);
   $stmt->bindParam("order_address",$order_address);
   $stmt->bindParam("off_addressgof",$addressgof);
   $stmt->bindParam("off_msisdngof",$msisdngof);
   

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

public function saveGof($gof_name,$transaction_type,$msisdngof,$addressgof,$amount,$passgof,$order_address,$off_msisdngof,$off_addressgof,$tran_status){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveGof(:gof_name,:transaction_type,:msisdngof,:addressgof,:amount,:passgof,:order_address,:off_msisdngof,:off_addressgof,:tran_status)");
   $stmt->bindParam("gof_name",$gof_name);
   $stmt->bindParam("transaction_type",$transaction_type);
   $stmt->bindParam("addressgof",$addressgof);
   $stmt->bindParam("msisdngof",$msisdngof);
   $stmt->bindParam("amount",$amount);
   $stmt->bindParam("passgof",$passgof);
   $stmt->bindParam("order_address",$order_address);
   $stmt->bindParam("off_addressgof",$addressgof);
   $stmt->bindParam("off_msisdngof",$msisdngof);
   $stmt->bindParam("tran_status",$tran_status);
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

public function deleteGof($idgof)
{
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("delete from m_gof where id_gof = :id");
   $stmt->bindParam("id",$idgof);
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

public function autoCompleteGof($term)
{
  $trm = "%".$term."%";
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("SELECT a.* FROM m_gof a WHERE  gof_name like :term or id_gof  like :term order by gof_name asc");
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
 END OF TABEL M_gof
 *******************************************************************************/

/******************************************************************************
    START TABEL m_got
    *******************************************************************************/
    public function getListgot()
    {
      $db = $this->dblocal;
      try
      {
       $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan,t.* FROM m_got t, 
        (SELECT @rownum := 0) r ORDER BY id_got ASC");
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

   public function getGot($id_got){
    $db = $this->dblocal;
    try
    {
     $stmt = $db->prepare("select a.* from m_got a where a.id_got = :id ");
     $stmt->bindParam("id",$id_got);
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


 public function updateGot($idgot,$got_name,$transaction_type,$msisdngot,$addressgot,$amount,$passgot,$order_address,$offmsisdngot,$offaddressgot)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_got
    SET  got_name = UPPER(:got_name),
     transaction_type= :transaction_type,  
    addressgot     = :addressgot,
    msisdngot      = :msisdngot, 
    amount         = :amount,
    passgot        = :passgot,
    order_address  = :order_address, 
    offaddressgot = :offaddressgot,
    offmsisdngot  = :offmsisdngot

   
    
    WHERE id_got= :idgot;");

   $stmt->bindParam("idgot",$idgot);
   $stmt->bindParam("got_name",$got_name);
   $stmt->bindParam("transaction_type",$transaction_type);
   $stmt->bindParam("addressgot",$addressgot);
   $stmt->bindParam("msisdngot",$msisdngot);
   $stmt->bindParam("amount",$amount);
   $stmt->bindParam("passgot",$passgot);
   $stmt->bindParam("order_address",$order_address);
   $stmt->bindParam("offaddressgot",$offaddressgot);
   $stmt->bindParam("offmsisdngot",$offmsisdngot);
   

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

public function saveGot($got_name,$transaction_type,$msisdngot,$addressgot,$amount,$passgot,$order_address,$offmsisdngot,$offaddressgot,$tran_status){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveGot(:got_name,:transaction_type,:msisdngot,:addressgot,:amount,:passgot,:order_address,:offmsisdngot,:offaddressgot,:tran_status)");
   $stmt->bindParam("got_name",$got_name);
   $stmt->bindParam("transaction_type",$transaction_type);
   $stmt->bindParam("addressgot",$addressgot);
   $stmt->bindParam("msisdngot",$msisdngot);
   $stmt->bindParam("amount",$amount);
   $stmt->bindParam("passgot",$passgot);
   $stmt->bindParam("order_address",$order_address);
   $stmt->bindParam("offaddressgot",$offaddressgot);
   $stmt->bindParam("offmsisdngot",$offmsisdngot);
   $stmt->bindParam("tran_status",$tran_status);
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

public function deleteGot($idgot)
{
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("delete from m_got where id_got = :id");
   $stmt->bindParam("id",$idgot);
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

public function autoCompletegot($term)
{
  $trm = "%".$term."%";
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("SELECT a.* FROM m_got a WHERE  got_name like :term or id_got  like :term order by got_name asc");
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
 END OF TABEL M_got
 *******************************************************************************/



 /******************************************************************************
    START TABEL m_p_receipt
    *******************************************************************************/
    public function getListpre()
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


 public function updatePre($idpre,$namepre,$transaction_type,$msisdnpre,$addresspre,$order_address,$offmsisdnpre,$offaddresspre,$farmsisdnpre,$faraddresspre,$passpre,$terms,$quantity,$amount)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_p_receipt
    SET  namepre = :namepre,
    transaction_type :transaction_type;
    msisdnpre       = :msisdnpre,
    addresspre      = :addresspre,
    offmsisdnpre        = :offmsisdnpre,
    offaddresspre        = :offaddresspre,
    farmsisdnpre            = :farmsisdnpre,
    faraddresspre          = :faraddresspre,
    order_address          = :order_address,
    passpre          = :passpre,
    terms          = :terms,
    quantity          = :quantity,
    amount          = :amount,
    order_rpt_address          = :order_rpt_address,
    outpre          = :outpre,
    outpred          = :outpred

    WHERE id_pre= :idpre;");

   $stmt->bindParam("idpre",$idpre);
   $stmt->bindParam("namepre",$namepre);
   $stmt->bindParam("transaction_type",$transaction_type);
   $stmt->bindParam("msisdnpre",$msisdnpre);
   $stmt->bindParam("addresspre",$addresspre);
   $stmt->bindParam("offmsisdnpre",$offmsisdnpre);
   $stmt->bindParam("offaddresspre",$offaddresspre);
   $stmt->bindParam("farmsisdnpre",$farmsisdnpre);
   $stmt->bindParam("faraddresspre",$faraddresspre);
   $stmt->bindParam("order_address",$order_address);
   $stmt->bindParam("passpre",$passpre);
   $stmt->bindParam("terms",$terms);
   $stmt->bindParam("quantity",$quantity);
   $stmt->bindParam("amount",$amount);
   $stmt->bindParam("order_rpt_address",$order_rpt_address);
   $stmt->bindParam("outpre",$outpre);
   $stmt->bindParam("outpred",$outpred); 

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

              public function savePre($namepre,$transaction_type,$msisdnpre,$addresspre,$order_address,$offmsisdnpre,$offaddresspre,$farmsisdnpre,$faraddresspre,$passpre,$terms,$quantity,$amount,$order_rpt_address,$outpre,$outpred){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call savePre(:namepre,:transaction_type,:msisdnpre,:addresspre,:order_address,:offmsisdnpre,:offaddresspre,:farmsisdnpre,:faraddresspre,:passpre,:terms,:quantity,:amount,:order_rpt_address,:outpre,:outpred)");
   $stmt->bindParam("namepre",$namepre);
   $stmt->bindParam("transaction_type",$transaction_type);
   $stmt->bindParam("msisdnpre",$msisdnpre);
   $stmt->bindParam("addresspre",$addresspre);
   $stmt->bindParam("order_address",$order_address);
   $stmt->bindParam("offmsisdnpre",$offmsisdnpre);
   $stmt->bindParam("offaddresspre",$offaddresspre);
   $stmt->bindParam("farmsisdnpre",$farmsisdnpre);
   $stmt->bindParam("faraddresspre",$faraddresspre);
   
   $stmt->bindParam("passpre",$passpre);
   $stmt->bindParam("terms",$terms);
   $stmt->bindParam("quantity",$quantity);
   $stmt->bindParam("amount",$amount);
   $stmt->bindParam("order_rpt_address",$order_rpt_address);
   $stmt->bindParam("outpre",$outpre);
   $stmt->bindParam("outpred",$outpred);
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
    START TABEL m_p_receipt_cer
    *******************************************************************************/
    public function getListcre()
    {
      $db = $this->dblocal;
      try
      {
       $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan,t.* FROM m_p_receipt_cer t, 
        (SELECT @rownum := 0) r ORDER BY id_cre ASC");
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

   public function getcre($id_cre){
    $db = $this->dblocal;
    try
    {
     $stmt = $db->prepare("select a.* from m_p_receipt_cer a where a.id_cre = :id ");
     $stmt->bindParam("id",$id_cre);
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


 public function updateCre($idcre,$cre_name,$transaction_type,$msisdncre,$oaddresscre,$oreceipt,$cermsisdncre,$ceraddresscre,$passcre,$outcre)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_p_receipt_cer
    SET  cre_name = :cre_name,
    msisdncre       = :msisdncre,
    transaction_type =transaction_type,
    oaddresscre      = :oaddresscre,
    cermsisdncre        = :cermsisdncre,
    ceraddresscre        = :ceraddresscre,
    oreceipt          = :oreceipt,
    passcre          = :passcre,
    outcre          = :outcre
    
    WHERE id_cre= :idcre;");

   $stmt->bindParam("idcre",$idcre);
   $stmt->bindParam("cre_name",$cre_name);
   $stmt->bindParam("transaction_type",$transaction_type);
   $stmt->bindParam("msisdncre",$msisdncre);
   $stmt->bindParam("oaddresscre",$oaddresscre);
   $stmt->bindParam("cermsisdncre",$cermsisdncre);
   $stmt->bindParam("ceraddresscre",$ceraddresscre);
   $stmt->bindParam("oreceipt",$oreceipt);
   $stmt->bindParam("passcre",$passcre);
   $stmt->bindParam("outcre",$outcre);
   
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

              public function saveCre($cre_name,$transaction_type,$msisdncre,$oaddresscre,$oreceipt,$cermsisdncre,$ceraddresscre,$passcre,$outcre){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveCre(:cre_name,:transaction_type,:msisdncre,:oaddresscre,:oreceipt,:cermsisdncre,:ceraddresscre,:passcre,:outcre)");
   //$stmt->bindParam("idcre",$idcre);
   $stmt->bindParam("cre_name",$cre_name);
   $stmt->bindParam("transaction_type",$transaction_type);
   $stmt->bindParam("msisdncre",$msisdncre);
   $stmt->bindParam("oaddresscre",$oaddresscre);
   $stmt->bindParam("cermsisdncre",$cermsisdncre);
   $stmt->bindParam("ceraddresscre",$ceraddresscre);
   $stmt->bindParam("oreceipt",$oreceipt);
   $stmt->bindParam("passcre",$passcre);
   $stmt->bindParam("outcre",$outcre);
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

public function deleteCre($idcre)
{
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("delete from m_p_receipt_cer where id_cre = :id");
   $stmt->bindParam("id",$idcre);
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

public function autoCompleteCre($term)
{
  $trm = "%".$term."%";
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("SELECT a.* FROM m_p_receipt_cer a WHERE  cre_name like :term or id_cre  like :term order by cre_name asc");
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
 END OF TABEL m_p_receipt_cer
 *******************************************************************************/



 /******************************************************************************
    START TABEL m_p_receipt_red
    *******************************************************************************/
    public function getListred()
    {
      $db = $this->dblocal;
      try
      {
       $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan,t.* FROM m_p_receipt_red t, 
        (SELECT @rownum := 0) r ORDER BY id_red ASC");
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

   public function getred($id_red){
    $db = $this->dblocal;
    try
    {
     $stmt = $db->prepare("select a.* from m_p_receipt_red a where a.id_red = :id ");
     $stmt->bindParam("id",$id_red);
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


 public function updateRed($idred,$red_name,$msisdnred,$oaddressred,$oreceipt,$farmsisdnred,$faraddressred,$passred,$outred)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_p_receipt_red
    SET  red_name = :red_name,
    msisdnred       = :msisdnred,
    oaddressred      = :oaddressred,
    farmsisdnred        = :farmsisdnred,
    faraddressred        = :faraddressred,
    oreceipt          = :oreceipt,
    passred          = :passred,
    outred          = :outred
    
    WHERE id_red= :idred;");

   $stmt->bindParam("idred",$idred);
   $stmt->bindParam("red_name",$red_name);
   $stmt->bindParam("msisdnred",$msisdnred);
   $stmt->bindParam("oaddressred",$oaddressred);
   $stmt->bindParam("farmsisdnred",$farmsisdnred);
   $stmt->bindParam("faraddressred",$faraddressred);
   $stmt->bindParam("oreceipt",$oreceipt);
   $stmt->bindParam("passred",$passred);
   $stmt->bindParam("outred",$outred);
   
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

              public function saveRed($red_name,$msisdnred,$oaddressred,$oreceipt,$farmsisdnred,$faraddressred,$passred,$outred){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveRed(:red_name,:msisdnred,:oaddressred,:oreceipt,:farmsisdnred,:faraddressred,:passred,:outred)");
   //$stmt->bindParam("idred",$idred);
   $stmt->bindParam("red_name",$red_name);
   $stmt->bindParam("msisdnred",$msisdnred);
   $stmt->bindParam("oaddressred",$oaddressred);
   $stmt->bindParam("farmsisdnred",$farmsisdnred);
   $stmt->bindParam("faraddressred",$faraddressred);
   $stmt->bindParam("oreceipt",$oreceipt);
   $stmt->bindParam("passred",$passred);
   $stmt->bindParam("outred",$outred);
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

public function deleteRed($idred)
{
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("delete from m_p_receipt_red where id_red = :id");
   $stmt->bindParam("id",$idred);
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

public function autoCompleteRed($term)
{
  $trm = "%".$term."%";
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("SELECT a.* FROM m_p_receipt_red a WHERE  red_name like :term or id_red  like :term order by red_name asc");
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
 END OF TABEL m_p_receipt_red
 *******************************************************************************/



 


/******************************************************************************
    START TABEL m_Cpr
    *******************************************************************************/
    public function getListcpr()
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


 public function updateCpr($idcpr,$cpr_name,$msisdncpr,$addresscpr,$order_address,$cermsisdncpr,$ceraddresscpr,$passcpr,$oreceipt,$outcpr)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_certify_receipt
    SET  cpr_name = UPPER(:cpr_name),
    msisdncpr = msisdncpr,
    addresscpr= :addresscpr,
    order_address= :order_address,
    cermsisdncpr= :cermsisdncpr,
    ceraddresscpr= :ceraddresscpr,
    passcpr= :passcpr,
    oreceipt= :oreceipt,
    outcpr= :outcpr

    
    WHERE id_cpr= :idcpr;");

   $stmt->bindParam("idcpr",$idcpr);
   $stmt->bindParam("cpr_name",$cpr_name);
   $stmt->bindParam("msisdncpr",$msisdncpr);
   $stmt->bindParam("addresscpr",$addresscpr);
   $stmt->bindParam("order_address",$order_address);
   $stmt->bindParam("cermsisdncpr",$cermsisdncpr);
   $stmt->bindParam("ceraddresscpr",$ceraddresscpr);
   $stmt->bindParam("passcpr",$passcpr);
   $stmt->bindParam("oreceipt",$oreceipt);
   $stmt->bindParam("outcpr",$outcpr);

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

public function saveCpr($cpr_name,$msisdncpr,$addresscpr,$order_address,$cermsisdncpr,$ceraddresscpr,$passcpr,$oreceipt,$outcpr){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveCpr(:cpr_name,:msisdncpr,:addresscpr,:order_address,:cermsisdncpr,:ceraddresscpr,:passcpr,:oreceipt,:outcpr)");

   $stmt->bindParam("cpr_name",$cpr_name);
   $stmt->bindParam("msisdncpr",$msisdncpr);
   $stmt->bindParam("addresscpr",$addresscpr);
   $stmt->bindParam("order_address",$order_address);
   $stmt->bindParam("cermsisdncpr",$cermsisdncpr);
   $stmt->bindParam("ceraddresscpr",$ceraddresscpr);
   $stmt->bindParam("passcpr",$passcpr);
   $stmt->bindParam("oreceipt",$oreceipt);
   $stmt->bindParam("outcpr",$outcpr);
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
   $stmt = $db->prepare("SELECT a.* FROM m_certify_receipt a WHERE  cpr_name like :term or id_cpr  like :term order by cpr_name asc");
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
    SET  cur_name = UPPER(:cur_name),
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

public function saveCur($cur_name,$currency_type,$amount,$addresscur,$msisdncur,$response,$tran_type){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveCur(:cur_name,:currency_type,:amount,:addresscur,:msisdncur,:response,:tran_type)");
   
    $stmt->bindParam("cur_name",$cur_name);
   $stmt->bindParam("currency_type",$currency_type);
   $stmt->bindParam("amount",$amount);
   $stmt->bindParam("addresscur",$addresscur);
   $stmt->bindParam("msisdncur",$msisdncur);
   $stmt->bindParam("response",$response);
   $stmt->bindParam("tran_type",$tran_type);
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
    START TABEL m_red_commission
    *******************************************************************************/
    public function getListRco()
    {
      $db = $this->dblocal;
      try
      {
       $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan,t.* FROM m_red_commission t, 
        (SELECT @rownum := 0) r ORDER BY id_rco ASC");
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

   public function getRco($id_rco){
    $db = $this->dblocal;
    try
    {
     $stmt = $db->prepare("select a.* from m_red_commission a where a.id_rco = :id ");
     $stmt->bindParam("id",$id_rco);
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


 public function updateRco($idrco,$rco_name,$commission,$redemption,$fixedredemption,$addressrco,$msisdnrco,$currency_type)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_red_commission
    SET  rco_name = UPPER(:rco_name),
    commission = :commission,
    redemption=         :redemption,
    fixedredemption=         :fixedredemption,
    addressrco=     :addressrco,
    msisdnrco=      :msisdnrco,
    currency_type=      :currency_type  
    
    WHERE id_rco= :idrco;");

   $stmt->bindParam("idrco",$idrco);
   $stmt->bindParam("rco_name",$rco_name);
   $stmt->bindParam("commission",$commission);
   $stmt->bindParam("redemption",$redemption);
   $stmt->bindParam("fixedredemption",$fixedredemption);
   $stmt->bindParam("addressrco",$addressrco);
   $stmt->bindParam("msisdnrco",$msisdnrco);
   $stmt->bindParam("currency_type",$currency_type);
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

public function saveRco($rco_name,$commission,$redemption,$fixedredemption,$addressrco,$msisdnrco,$outaddress,$outcom,$outred,$currency_type){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveRco(:rco_name,:commission,:redemption,:fixedredemption,:addressrco,:msisdnrco,:outaddress,:outcom,:outred,:currency_type)");
   
    $stmt->bindParam("rco_name",$rco_name);
   $stmt->bindParam("commission",$commission);
   $stmt->bindParam("redemption",$redemption);
   $stmt->bindParam("fixedredemption",$fixedredemption);
   $stmt->bindParam("addressrco",$addressrco);
   $stmt->bindParam("msisdnrco",$msisdnrco);
   $stmt->bindParam("outaddress",$outaddress);
   $stmt->bindParam("outcom",$outcom);
   $stmt->bindParam("outred",$outred);
   $stmt->bindParam("currency_type",$currency_type);
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

public function deleterco($idrco)
{
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("delete from m_red_commission where id_rco = :id");
   $stmt->bindParam("id",$idrco);
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

public function autoCompleterco($term)
{
  $trm = "%".$term."%";
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("SELECT a.* FROM m_red_commission a WHERE  rco_name like :term or id_rco  like :term order by rco_name asc");
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
 END OF TABEL m_red_commission
 *******************************************************************************/



 /******************************************************************************
    START TABEL m_buy_currency
    *******************************************************************************/
    public function getListMul()
    {
      $db = $this->dblocal;
      try
      {
       $stmt = $db->prepare("SELECT @rownum := @rownum + 1 AS urutan,t.* FROM m_buy_currency t, 
        (SELECT @rownum := 0) r ORDER BY id_mul ASC");
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

   public function getMul($id_mul){
    $db = $this->dblocal;
    try
    {
     $stmt = $db->prepare("select a.* from m_buy_currency a where a.id_mul = :id ");
     $stmt->bindParam("id",$id_mul);
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


 public function updateMul($idmul,$mul_name,$currency_type,$exchanged_currency,$amount,$addressmul,$msisdnmul,$addressmuldes,$msisdnmuldes,$frompw)
 {
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("UPDATE m_buy_currency
    SET  mul_name =      :mul_name,
    currency_type =      :currency_type,
    exchanged_currency = :exchanged_currency,
    amount=            :amount,
    addressmul=        :addressmul,
    msisdnmul=         :msisdnmul,  
    addressmuldes=     :addressmuldes,
    msisdnmuldes=      :msisdnmuldes, 
    frompw=             :frompw 
    
    WHERE id_mul= :idmul;");

   $stmt->bindParam("idmul",$idmul);
   $stmt->bindParam("mul_name",$mul_name);
   $stmt->bindParam("currency_type",$currency_type);
   $stmt->bindParam("exchanged_currency",$exchanged_currency);
   $stmt->bindParam("amount",$amount);
   $stmt->bindParam("addressmul",$addressmul);
   $stmt->bindParam("msisdnmul",$msisdnmul);
   $stmt->bindParam("addressmuldes",$addressmuldes);
   $stmt->bindParam("msisdnmuldes",$msisdnmuldes);
   $stmt->bindParam("frompw",$frompw);
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

public function saveMul($mul_name,$currency_type,$exchanged_currency,$amount,$addressmul,$msisdnmul,$addressmuldes,$msisdnmuldes,$frompw,$tran_id){
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("call saveMul(:mul_name,:currency_type,:exchanged_currency,:amount,:addressmul,:msisdnmul,:addressmuldes,:msisdnmuldes,:frompw,:tran_id)");
   
    $stmt->bindParam("mul_name",$mul_name);
   $stmt->bindParam("currency_type",$currency_type);
   $stmt->bindParam("exchanged_currency",$exchanged_currency);
   $stmt->bindParam("amount",$amount);
   $stmt->bindParam("addressmul",$addressmul);
   $stmt->bindParam("msisdnmul",$msisdnmul);
   $stmt->bindParam("addressmuldes",$addressmuldes);
   $stmt->bindParam("msisdnmuldes",$msisdnmuldes);
   $stmt->bindParam("frompw",$frompw);
   $stmt->bindParam("tran_id",$tran_id);
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

public function deleteMul($idmul)
{
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("delete from m_buy_currency where id_mul = :id");
   $stmt->bindParam("id",$idmul);
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

public function autoCompleteMul($term)
{
  $trm = "%".$term."%";
  $db = $this->dblocal;
  try
  {
   $stmt = $db->prepare("SELECT a.* FROM m_buy_currency a WHERE  mul_name like :term or id_mul  like :term order by mul_name asc");
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
 END OF TABEL m_buy_currency
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
      //AES_DECRYPT(a.pass_user,'blockchain')
     $db = $this->dblocal;
     try
     {
      $stmt = $db->prepare("select a.*,
        (select name_shop from r_ref_system where id = 1) as name_shop,
        (select address_shop from r_ref_system where id = 1) as address_shop,
        (select phone_shop from r_ref_system where id = 1) as phone_shop
        from m_user a where  upper(a.username)=upper(:user) and AES_DECRYPT(a.pass_user,'blockchain')=md5(:id)");
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
      $stmt = $db->prepare("select wphone,b_address,b_token,AES_DECRYPT(pass_user,'blockchain') as pass from m_user a where username = :uname");
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

  public function getblockpass($uname)
  {
    $db = $this->dblocal;
    try
    {
      $stmt = $db->prepare("select wphone,b_address,b_token,AES_DECRYPT(pass_user,'blockchain') as pass from m_user a where wphone = :uname");
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
