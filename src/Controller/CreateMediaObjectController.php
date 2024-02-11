<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\MediaObject;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Vich\UploaderBundle\Storage\StorageInterface;

#[AsController]
class CreateMediaObjectController extends AbstractController
{
    public function __invoke(Request $request, StorageInterface $storage, EntityManagerInterface $em): Book
    {
        $uploadedFile = $request->files->get('image');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $mediaObject = new MediaObject();
        $mediaObject->file = $uploadedFile;
        $mediaObject->contentUrl = $storage->resolvePath($mediaObject, 'file');

        $em->persist($mediaObject);

        $em->flush();

        $book = new Book();
        $book->setName($request->get('name'));
        $book->setDescription($request->get('description'));
        $book->setPublishDate();
        $book->setImage($mediaObject);

        foreach ($request->get('authors') as $author) {
            $book->addAuthor($em->getRepository(Author::class)->find((int) $author));
        }

        return $book;
    }
}