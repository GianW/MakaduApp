import mx.controls.*;
import mx.utils.Delegate;
import flash.net.*;
import com.oinam.util.UploadQueue;

var browseLabel:Label;
var browseButton:MovieClip;
var clearButton:Button;
var uploadFilesList:List;
var uploadButton:Button;
var uploadProgressBar:ProgressBar;

uploadProgressBar.setStyle("themeColor", 0x000000);
uploadProgressBar.setStyle("fontColor", 0x000000);

function uploadMultiploFlame() 
{
	Stage.scaleMode = "noScale";
	Stage.align = "TL";
	stop ();

	//TIPOS DE ARQUIVOS QUE PODEM TER UPLOAD
	
	fileTypes = [{description:"Imagens", extension:"*.jpg; *.gif; *.png; *.jpeg"}];

	//ARQUIVO EM PHP QUE IRA CONTROLAR O UPLOAD
	if (uploadUrl == null) 
	{
		uploadUrl = "fotos_upload.php?id="+_level0.id+"&tipo="+_level0.tipo;
	}

	//TAMANHO MAXIMO EM KB
	if (maxFileSize == null) 
	{
		maxFileSize = 50000;
	};

	appUrl = _url.substring (0, _url.lastIndexOf ("/"));

	//HABILITANDO BUSCA
	browseButton.enabled = true;
	uploadButton.enabled = false; //UPLOAD DESABILITADO
	uploadProgressBar.visible = false; //BARRA DE PROGRESSO DESABILITADA
	progresso._visible = false;
	uploadFilesList.visible = false;

	//PREENCHE LISTA DE ARQUIVOS PARA UPLOAD
	uploadFilesList.dataProvider = [];
	uploadFilesList.labelFunction = function (data:Object):String 
	{
		return (data.name + " (" + Math.round (data.size/1024) + "kb)");
	};

	//CRIA LISTENERS PARA OS BOTÕES EM REFERENCIA A LISTA
	var buttonDelegate:Function = Delegate.create (this, buttonChanged);
	browseButton.addEventListener ("click", buttonDelegate);
	clearButton.addEventListener ("click", buttonDelegate);
	uploadButton.addEventListener ("click", buttonDelegate);
	refreshButton.addEventListener ("click", buttonDelegate);
	downloadButton.addEventListener ("click", buttonDelegate);

	uploadRefList = new FileReferenceList ();
	uploadRefListener = new Object ();
	uploadRefListener.onSelect = function (refList:FileReferenceList) 
	{
		var invalidFiles:Number = 0;
		var n:Number = refList.fileList.length;
		var s:String = "Apenas imagens menores de " + maxFileSize + "kb são permitidas. ";
		var file:FileReference;
		for (var i:Number = 0; i < n; ++i) 
		{
			file = refList.fileList [i];
			if (file.size/1024 > maxFileSize) 
			{
				refList.fileList.splice (i, 1);
				invalidFiles++;
			};
		};

		if (invalidFiles > 0) 
		{
			s += invalidFiles + " arquivos foram ignorados.";
			showAlert ("Erro", s);
		};

		uploadFilesList.visible = true;
		uploadFilesList.dataProvider = uploadFilesList.dataProvider.concat (refList.fileList);
		uploadQueue.start (uploadFilesList.dataProvider);
	};

	uploadRefList.addListener (uploadRefListener);

	uploadQueue = new UploadQueue (uploadUrl);
	uploadDelegate = Delegate.create (this, uploadQueueChanged);

	uploadQueue.addEventListener ("start", uploadDelegate);
	uploadQueue.addEventListener ("progress", uploadDelegate);
	uploadQueue.addEventListener ("error", uploadDelegate);
	uploadQueue.addEventListener ("complete", uploadDelegate);
};

function showAlert (title:String, message:String) 
{
	message += "\t\r\r\r";

	Alert.yesLabel = "Ok";
	Alert.show (message, title, Alert.OK);
};

function trace2 () 
{
	trace (arguments.join (" : "));
};

	
browseButton.onRelease = function(){
	uploadRefList.browse (fileTypes);
}

function buttonChanged (eventObj:Object) 
{
	switch (eventObj.target) 
	{

		case clearButton:
			uploadFilesList.dataProvider = [];
			uploadButton.enabled = false;
			break;

		case uploadButton:
			uploadQueue.start (uploadFilesList.dataProvider);
			break;

		case refreshButton:
			break;
	};
};

function loadUploadList () 
{
	filesXml = new XML ();
	filesXml.ignoreWhite = true;
	filesXml.onLoad = function (success:Boolean) 
	{
		if (success) 
		{
			downloadFilesList.dataProvider = this.firstChild.childNodes;
		} 
		else 
		{
			trace2 ("Error unable to load download file list");
		};
	};

	filesXml.load (downloadListUrl);
};

function uploadQueueChanged (eventObj:Object) 
{
	switch (eventObj.type) 
	{
	
		case "start":
			uploadProgressBar.visible = true;
			uploadProgressBar.label = "Adicionando arquivos ...";
			progresso._visible = true;
			uploadButton.enabled = false;
			break;
		
		case "progress":
			uploadProgressBar.setProgress (eventObj.percent, 100);
			break;

		case "complete":
			uploadProgressBar.label = "Upload Completo";
			uploadButton.enabled = true;
			clearButton.dispatchEvent ({type:"click"});
			getURL("javascript:window.location.href = 'agnd_fotos.php?id="+_level0.id+"&tipo="+_level0.tipo+"';");
			break;

		case "error":
			uploadButton.enabled = true;
			showAlert (eventObj.info, "Error");
			break;
		
	};
};


//INICIALIZANDO UPLOAD MULTIPLO
uploadMultiploFlame();