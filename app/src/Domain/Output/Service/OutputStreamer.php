<?php


namespace App\Domain\Output\Service;

use App\Filesystem\Storage;
use Nyholm\Psr7\Stream;


final class OutputStreamer {

    private Storage $storage;

    public function __construct(Storage $storage) {
        $this->storage = $storage;
    }

    public function getStream($output) {

        //  content negotation depending on $output["size_job"]
        //  if size == 1 : .pdf
        //  else .zip

        //  https://discourse.slimframework.com/t/slim4-output-buffering-large-files-zip-streaming/4917/2

        $filename = "pdftk_test_document.pdf";  // testing

        $file = $this->storage->read($filename);
        $stream = Stream::create($file);

        return $stream;

    }

}