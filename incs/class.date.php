<?
class Date
{
  var $classname      = "Date";
  // public
  var $strDate;
  var $arrayDate      = array();  

  var $separator      = "-";
  
  function pegaData($data,$sep='/'){
  	$data=substr($data,0,10);
	$data=explode('-',$data);
	$data=$data[2].$sep.$data[1].$sep.$data[0];
	return $data;
  }
  function toMysql($data){
  	$sep='-';
  	$data=substr($data,0,10);
	$data=explode('/',$data);
	$data=$data[2].$sep.$data[1].$sep.$data[0];
	return $data;
  }
  
  
  function now()
  {
	return date("Y-m-d H:i:s",time());	
  }

  /************************************************************
  * input: Array  or triplet "$day $month $year" or string    *
  * output: formated string with global $separator 	      *
  *         string format YYYY-MM-DD 			      *
  ************************************************************/			
  function getStr($day,$month="",$year="")
  {	
	$this->convert($day,$month,$year);
	return $this->strDate;
  }

  /************************************************************
  * input:  Array or triplet "$day $month $year" or string    *
  * output: Array 					      *
  * Array format Date[year]=YYYY, Date[month]=MM, Date[dd]=DD *
  ************************************************************/
  function getArray($day,$month="",$year="")
  {
        $this->convert($day,$month,$year);
	return $this->arrayDate;
  }

  /************************************************************
  * not implemented					      *
  ************************************************************/
  function add()
  {
  }

  /************************************************************
  * not implemented                                           *
  ************************************************************/
  function sub()
  {
  }

  /************************************************************
  * input:  Array or triplet "$day $month $year" or string    *
  * output: 1 if left > right                                 *
  ************************************************************/
  function isGreat($left,$right)
  {
	$aLeft  = $this->convert($left);
	$aRight = $this->convert($right);

	if($aLeft[year] > $aRight[year]){
		return 1;
	}elseif($aLeft[year] < $aRight[year]){
		return 0;
	}else{
		if($aLeft[month] > $aRight[month]){
			return 1;
		}elseif($aLeft[month] < $aRight[month]){
			return 0;
		}else{
			if($aLeft[day] > $aRight[day]){
				return 1;
			}
		}
	}
   return 0;
  }

  /************************************************************
  * input:  Array or triplet "$day $month $year" or string    *
  * output: 1 if left < right                                 *
  ************************************************************/
  function isLess($left,$right)
  {
	return $this->isGreat($right,$left);		
  }

  /************************************************************
  * input:  Array or triplet "$day $month $year" or string    *
  * output: 1 if left = right                                 *
  ************************************************************/
  function isEqual($left,$right)
  {   
	$aLeft  = $this->convert($left);
        $aRight = $this->convert($right);

	if($this->ArrayToStr($aLeft) == $this->ArrayToStr($aRight)){ 
		return 1;
	}else{
		return 0;
	}
  }

  /************************************************************
  * input:  Array or triplet "$day $month $year" or string    *
  * output: 1 if left >= right                                *
  ************************************************************/
  function isGreatOrEqual($left,$right)
  {
	$test = $this->isGreat($left,$right) | $this->isEqual($left,$right);
	return $test;
  }
  
  /************************************************************
  * input:  Array or triplet "$day $month $year" or string    *
  * output: 1 is date valid                                   *
  ************************************************************/
  function validate($day,$month="",$year="")
  {
	$this->convert($day,$month,$year);
	/* FIX ME may be make first parameter Array */
	if(!preg_match("/^\d{1,2}$/",$this->arrayDate[day])){
		return 0;
	}
        if(!preg_match("/^\d{1,2}$/",$this->arrayDate[month])){
               return 0;
        }

	$year = "20".$year;
        if(!preg_match("/^\d{1,4}$/",$this->arrayDate[year])){
                return 0;
        }
	

	switch($this->arrayDate[month]){
		case "03":
		case "05": 
		case "08":
		case "12": 
		case "07": 
		case "10":
                	if($this->arrayDate[day] < 32 ){ return 1;}else{ return 0;} 
		break;

        	case "01":
		case "04": 
		case "06": 
		case "09":
		case "11":
                	if($this->arrayDate[day] < 31){ return 1;}else{ return 0;}
		break;

        	case "02":
                	$leap=(($this->arrayDate[year]-2000)/4);
                	$type=gettype($leap);
                if($type == "integer"){ 
			$daysin="29";
		}else{ 
			$daysin="28"; 
		}
                  if($this->arrayDate[day] < ($daysin+1)){ return 1;}else{ return 0;}
		break;
	default:
		return 0;
	}
  }	
  
  /************************************************************
  * input:  Array or triplet "$day $month $year" or string    *
  * output: date Array                                        *
  * Array format Date[year]=YYYY, Date[month]=MM, Date[dd]=DD *
  ************************************************************/
  function convert($day,$month="",$year="")
  {
	if(is_array($day)){
		$this->arrayDate = $day;
		$this->strDate = $this->ArrayToStr($day);
	}elseif(is_string($day) && empty($month)){
		$this->strDate = $day;
		$this->splitStr($day);
	}else{
 		$this->arrayDate[day]   = $day;
		$this->arrayDate[month] = $month;
		$this->arrayDate[year]  = $year;
		$this->strDate = $this->ArrayToStr($this->arrayDate);
	}
    return $this->arrayDate;
  }

  /************************************************************
  * input:  Array and separator                               *
  * output: string                                            *
  * string format YYYY-MM-DD                                  *
  * Array format Date[year]=YYYY, Date[month]=MM, Date[dd]=DD *
  ************************************************************/
  function ArrayToStr($arrayDate,$separator="")
  {	
	if(empty($separator)) $separator = $this->separator;
 	$str  = $arrayDate[year].$separator;
	$str .= $arrayDate[month].$separator;
	$str .= $arrayDate[day];

	return $str;
  }
  /************************************************************
  * input:  triplet "$day $month $year"  		      *
  * output: string                                            *
  * string format YYYY-MM-DD                                  *
  ************************************************************/
  function ToStr($day,$month,$year)
  {	
 	$this->arrayDate[day]   = $day;
	$this->arrayDate[month] = $month;
	$this->arrayDate[year]  = $year;

	return $this->ArrayToStr($this->arrayDate);
  }


  function splitStr($str)
  {
	list($this->arrayDate[year],
	     $this->arrayDate[month],
         $this->arrayDate[day] ) = split("-",$str);	

	/* FIX ME */
        if(strlen($this->arrayDate[year]) < 4){
                $this->arrayDate[year] = "20".$this->arrayDate[year];
        }
  }

} // end of class
?>
