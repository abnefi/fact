<?php
/**
 * Created by IntelliJ IDEA.
 * User: amelina
 * Date: 08/02/2019
 * Time: 12:59
 */

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gaufrette\Filesystem;
use Symfony\Component\DependencyInjection\Container as Container;


class FileUpload
{
    private static $allowedMimeTypes = array(
        'image/jpeg',
        'image/png',
        'image/gif',
        'application/pdf'
    );

    private static $allowedMimeTypesExcel = array(
        '.csv',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-excel',
    );

    private $filesystem;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }


    public function upload($element, UploadedFile $file, $code = null)
    {
        // Check if the file's mime type is in the list of allowed mime types.
        if (!in_array($file->getClientMimeType(), self::$allowedMimeTypes)) {
            throw new \InvalidArgumentException(sprintf('Files of type %s are not allowed.', $file->getClientMimeType()));
        }
//        dump($file->getClientOriginalName(), uniqid(), $element);die();

        // Generate a unique filename based on the date and add file extension of the uploaded file
        switch ($element) {
//            case "candidat":
//                $filename = sprintf('%s/%s.%s', $code, uniqid(), $file->getClientOriginalExtension());
//                break;

            case "societe":
                $filename = sprintf('%s/%s.%s', $code, uniqid(), $file->getClientOriginalName());
                break;

            case "facture":
                $filename = sprintf('%s/%s.%s', $code, uniqid(), $file->getClientOriginalExtension());
                break;

            case "declaration":
                $filename = sprintf('%s.%s', $code, uniqid(), $file->getClientOriginalExtension());
                break;
        }


        $system = $element . "_filesystem";
        $filesystem = $this->container->get($element . '_filesystem');
        //dump($filesystem);die();
        $adapter = $filesystem->getAdapter();
        //$adapter->setMetadata($filename, array('contentType' => $file->getClientMimeType()));
        $adapter->write($filename, file_get_contents($file->getPathname()));

        return $filename;
    }

    public function uploadExcelFile($element, UploadedFile $file, $code = null)
    {
        // Check if the file's mime type is in the list of allowed mime types.
        if (!in_array($file->getClientMimeType(), self::$allowedMimeTypesExcel)) {
            throw new \InvalidArgumentException(sprintf('Files of type %s are not allowed.', $file->getClientMimeType()));
        }
        // Generate a unique filename based on the date and add file extension of the uploaded file

        $filename = sprintf('%s/%s.%s', $code, uniqid(), $file->getClientOriginalExtension());
        $system = $element . "_filesystem";
        $filesystem = $this->container->get($element . '_filesystem');
        //dump($filesystem);die();
        $adapter = $filesystem->getAdapter();
        //$adapter->setMetadata($filename, array('contentType' => $file->getClientMimeType()));
        $adapter->write($filename, file_get_contents($file->getPathname()));

        return $filename;
    }
}