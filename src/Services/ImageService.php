<?php

namespace App\Services ;

use App\Entity\Vitrine;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService extends AbstractController{

    public function moveImage(UploadedFile $file , Vitrine $vitrine ) :void{
        $dossier_upload = $this->getParameter("upload_directory");
        $photo = md5(uniqid()) . "." . $file->guessExtension(); // .jpg
        $file->move( $dossier_upload , $photo  ); 
        $vitrine->setImage($photo);
    }

    public function deleteImage(Vitrine $vitrine) :void{
         // suppression du fichier dans le dossier upload
         $dossier_upload = $this->getParameter("upload_directory");
         $photo = $vitrine->getImage();
         $oldPhoto = $dossier_upload . "/" . $photo ;
         if(file_exists($oldPhoto)){
             unlink($oldPhoto); 
         }
         // fin suppression du fichier dans le dossier upload
    }

    public function updateImage(UploadedFile $file ,Vitrine $vitrine) :void{
        $this->deleteImage($vitrine);
        $this->moveImage($file , $vitrine );
    }

}