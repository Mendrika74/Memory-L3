<?php

namespace App\Controller;

use FtpClient\FtpClient;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AudioController extends AbstractController
{   
    /**
     * @Route("/audio", name="audio")
     */
    public function index()
    {
        $host = "147.135.254.144";    //  192.168.43.247  or 10.0.56.239
        $login = "vicidial";         //VirusTotal
        $password = "V1c1d1@L";        //virus   
        //$remote_file = ".";              
        $local_file = "D:\TP_symfony\demo\\EFS_2\public\\ftp";       
        $ftp = new \FtpClient\FtpClient();
        $conn_id = $ftp->connect($host);
        if($ftp->login($login, $password))
        {           
            $sizeGo = $ftp->dirSize($remote_file,true); 
            $sizeMo = $sizeGo * 1024 * 1024;
            $total = $ftp->count();   
            $ftp_name = $ftp->get($conn_id);     
                                    
            $files =   $ftp->nlist($remote_file);                 
            $dir ="D:\TP_symfony\demo\\EFS_2\public\\listening";
            $mask = "*.mp3";
             array_map( "unlink", glob("D:/TP_symfony/demo/EFS_2/public/listening/" . $mask ) );
            return $this->render('audio/index_audio.html.twig', [               
                'size' => $sizeMo,
                'name' => $ftp_name,
                'total' => $total,
                'listes' => $files,
                //'path' => $path,
            ]);
        } else {
            return $this->render('audio/index_audio.html.twig', [
                'response' => 'Erreur s\'est produite',
            ]);
        }
    }
   
    /**
     * @Route("/audio/show", name="play_audio") 
     */
    public function play(Request $request)
    {
        $title = $request->get('Title');       

        $source_directory = "."; 
       $host = "147.135.254.144";    
        $login = "vicidial";         
        $password = "V1c1d1@L";        
        //$remote_file = ".";             
        $local_file = "D:\TP_symfony\demo\\EFS_2\public\\listening";
        $mode = FTP_BINARY;
        $ftp = new \FtpClient\FtpClient();
        $conn_id = $ftp->connect($host);
        if($ftp->login($login, $password)){
            if ($source_directory != ".") { 
                if ($this->ftp->chdir($source_directory) == false) { 
                    throw new FtpException("Unable to change directory: ".$source_directory);
                }
                if (!(is_dir($source_directory))) {
                    mkdir($source_directory);
                }
                chdir($source_directory); 
            }            
            $contents = $ftp->nlist('.');
            foreach ($contents as $file) { 
                if ($file == '.' || $file == '..') {    
                    continue;
                }

                $ftp->get($local_file."/".$title, $title, $mode);
            }
        }                     
        return $this->render('audio/play_audio.html.twig', [
            'file' => $title
        ]);
    }
  
    /**
     * @Route("/audio/donwloadFile", name="download_audio")
     */
    public function Download(Request $request)
    {
        $title = $request->get('Title');       
        $source_directory = "."; 
       $host = "147.135.254.144";  
        $login = "vicidial";      
        $password = "V1c1d1@L";       
        $remote_file = "\M\mahaleo";             
        $local_file = "D:\From_server_one";
        $mode = FTP_BINARY;
        $ftp = new \FtpClient\FtpClient();
        $conn_id = $ftp->connect($host);
        if($ftp->login($login, $password)){
            if ($source_directory != ".") { 
                if ($this->ftp->chdir($source_directory) == false) { 
                    throw new FtpException("Unable to change directory: ".$source_directory);
                }
                if (!(is_dir($source_directory))) {
                    mkdir($source_directory);
                }
                chdir($source_directory); 
            } 
            $contents = $ftp->nlist('.');
            foreach ($contents as $file) { 
                if ($file == '.' || $file == '..') {    
                    continue;
                }

                $ftp->get($local_file."/".$title, $title, $mode);
            }
        }       
        return $this->render('audio/downSingle.html.twig', [
            'Title' => "content"
        ]);
    }

   /**
    *
    * 
    * @Route("/audio/downloadAll", name="download_all_audio")
    */
    public function DownloadAll()
    {
       $host = "147.135.254.144";    
        $login = "vicidial";         
        $password = "V1c1d1@L";  
        
        $remote_file = ".";              
        $local_file = "D:\From_server_all";        
        $ftp = new \FtpClient\FtpClient();
        $conn_id = $ftp->connect($host);
        if($ftp->login($login, $password))
        {           
          $downloaded = $ftp->getAll($remote_file , $local_file);   
            
        }
      return $this->redirectToRoute('audio');
    }    



      /**
     * To another perspectives for Update nextly
     * 
     * @Route("/audio/download/force", name="download_force_audio")
     */
    public function Downloader(Request $request)
    {
        $success= "all is ok !";
        $failed="all is failed !";
        $file = $request->get('Title');
        $taille=filesize("D:/TP_symfony/demo/EFS_2/public/ftp/".  $file);
        header("Content-Type: application/force-download; name=\"$file\"");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: $taille");
        header("Content-Disposition: attachment; filename=\"$file\"");
        header("Expires: 0");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        readfile("D:/TP_symfony/demo/EFS_2/public/ftp/$file");
        exit();
        return $this->render('audio/essai_audio.html.twig', [
            'status' => $success
        ]);
    }        



    //$host = "147.135.254.144";
        //$login = "itocean";
        //$password = "oceancallcentre";
 //$path = "D:/TP_symfony/demo/EFS_2/public/ftp";
 // $downloaded = $ftp->getAll($remote_file , $local_file);

}
