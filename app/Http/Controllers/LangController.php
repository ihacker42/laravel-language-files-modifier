<?php
namespace App\Http\Controllers;

use App;
use File;
use Lang;
use Auth;
use Config;
use Session;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LangController extends Controller
{
	private $lang = 'en';
	private $request;
	
    private $file;
    private $key;
    private $path;
    private $arrayLang = array();
	
	public function __construct(Request $request) {
		$this->request 		=	$request;
		$this->lang 		=	Config::get('app.locale');
		$this->langArray	=	Config::get('app.locales');
		$this->addFolders();
	}
	
	public function getFiles() {
		$files	=	[];
		
		$filesInFolder	=	File::allFiles(base_path()."/resources/lang/en/");
		foreach($filesInFolder as $file) {
			if(!in_array(pathinfo($file)["filename"],["validation"]))
				array_push($files, pathinfo($file)["filename"]);
		}
		
		return view("Translation.all",compact("files"));
	}
	
	public function createFile() {
		return view("Translation.create");
	}
	
	public function createFileData() {
		$validator	=	Validator::make($this->request->all(), [
			'file'			=> 'required',
		]);
		
		if($validator->fails())
			return response()->json([ 'success' => false, 'errors' => $validator->errors(), 'message' => trans('Please Fill All Fields!!!') ]);
		
		$this->file	=	$this->request->file;
		if(file_exists(base_path()."/resources/lang/en/$this->file.php"))
        	return response()->json([ "success" => false, "message" => "File Already Exist!!!" ]);
        
        $this->arrayLang	=	$this->request->arrayLang;
        ksort($this->arrayLang,SORT_STRING | SORT_FLAG_CASE);
		$this->create();
		
		$langArray	=	Config::get('app.locales');
		foreach($langArray as $lang) {
			File::copy(base_path()."/resources/lang/en/$this->file.php",base_path()."/resources/lang/$lang/$this->file.php");
		}
		
		return response()->json([ "success" => true, "message" => "File Created Successfully!!!" ]);
    }
	
	public function editFile() {
		$this->file	=	$file	=	$this->request->file;
		
		$data		=	$this->read();
		
		if($this->request->has("dev"))
			return $data;
		
		return view("Translation.edit",compact("data",'file'));
	}
	
	public function editFileData() {
		$this->file	=	$this->request->file;
		$this->read();
		
        $this->arrayLang[$this->request->key]	=	$this->request->value;
        
        ksort($this->arrayLang,SORT_STRING | SORT_FLAG_CASE);
        
        $this->save();
        
		return response()->json([ "success" => true, "message" => "Key Updated!!" ]);
	}
	
	public function addKey() {
		return view("Translation.add");
	}
	
	public function addKeyData() {
		$this->request->validate([
			'key'		=>	'required',
			'value_en'	=>	'required',
			'value_hi'	=>	'required',
			'value_te'	=>	'required',
			'value_ta'	=>	'required',
			'value_mr'	=>	'required',
		]);
		
		$this->file	=	$this->request->file;
		$this->key	=	$this->request->key;
		
		foreach($this->langArray as $lang) {
			$this->lang	=	$lang;
			App::setLocale($lang);
			$this->read();
			
			if(array_key_exists($this->key,$this->arrayLang))
				continue;
			
			$this->arrayLang[$this->key]	=	$this->request->input("value_$this->lang");
			ksort($this->arrayLang,SORT_STRING | SORT_FLAG_CASE);
			
			$this->save();
		}
		
		Session::flash("message", "New Key Added!!");
		Session::flash('type', 'success');
    	return redirect()->route('Lang.addKey',$this->file);
	}
	
	public function deleteKey() {
		$this->file	=	$this->request->file;
		$this->key	=	$this->request->key;
		foreach($this->langArray as $lang) {
			$this->lang	=	$lang;
			App::setLocale($lang);
			$this->delete();
		}
        
		return response()->json([ "success" => true, "message" => "Key Deleted!!" ]);
	}

	public function addFolders() {
		foreach($this->langArray as $lang) {
			$folderPath	=	base_path()."/resources/lang/$lang";
			if(!file_exists($folderPath))
				mkdir($folderPath, 0777, true);
		}
	}
	
	public function create() {
		$path		=	base_path()."/resources/lang/en/$this->file.php";
		$file		=	fopen($path,"w");
		$content	=	"<?php\n\treturn [\n";
        foreach ($this->arrayLang as $key => $value) {
            $content	.=	"\t\t".'"'.$key.'"'."\t=>\t".'"'.$value.'",'."\n";
        }
        $content	.=	"\t];\n?>";
		fwrite($file,$content);
		fclose($file);
	}
	
	public function read() {
        $this->path			=	base_path()."/resources/lang/$this->lang/$this->file.php";
        
        if(!file_exists($this->path) && $this->lang != "en")
        	File::copy(base_path()."/resources/lang/en/$this->file.php",$this->path);
        
        $this->arrayLang	=	Lang::get($this->file);
        
        if (gettype($this->arrayLang) == 'string') $this->arrayLang = array();
        
        return $this->arrayLang;
    }

    public function save() {
        $content	=	"<?php\n\treturn [\n";
        foreach ($this->arrayLang as $key => $value) {
            $content	.=	"\t\t".'"'.$key.'"'."\t=>\t".'"'.$value.'",'."\n";
        }
        $content	.=	"\t];\n?>";
        file_put_contents($this->path, $content);
    }
    
    public function delete() {
		$this->read();
		unset($this->arrayLang[$this->key]);
		$this->save();
    }
}