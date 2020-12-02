<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UploadController extends AbstractController
{
    /**
     * @Route("/upload", name="app_bundle_upload", methods={"POST"})
     */
    public function upload(Request $request, ValidatorInterface $validator): Response
    {
        $entity = new File();
        $entity->file = $request->files->get('file');

        $errors = $validator->validate($entity);

        if (0 < \count($errors)) {
            foreach ($errors as $error) {
                $result[] = $error->getMessage();
            }
        } else {
            $result = ['success' => true];
        }

        return $this->json($result);
    }
}
