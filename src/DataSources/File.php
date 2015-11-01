<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 01/11/15
 * Time: 19:46
 */

namespace Ndrx\Profiler\DataSources;


use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\Process;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class File implements DataSourceInterface
{

    protected $folder;

    protected $filesystem;

    /**
     * File constructor.
     */
    public function __construct($outputFolder)
    {
        $this->folder = $outputFolder;

        $this->filesystem = new Filesystem();
    }

    public function getProcess($processId)
    {
        $finder = new Finder();
        $iterator = $finder
            ->name('*.json')
            ->sortByName()
            ->in($this->getProcessFolder($processId));

        /** @var SplFileInfo $file */
        foreach($iterator as $file) {
            yield file_get_contents($file->getPath() . DIRECTORY_SEPARATOR . $file->getFilename());
        }
    }

    public function clear()
    {
        $finder = new Finder();
        $this->filesystem->remove($finder->in($this->folder));
    }

    public function deleteProcess($processId)
    {
        $finder = new Finder();
        $this->filesystem->remove($finder->in($this->getProcessFolder($processId)));
    }

    public function save(Process $process, array $item)
    {
        $processFolder = $this->getProcessFolder($process->getId());

        if (!is_dir($processFolder)) {
            $this->filesystem->mkdir($processFolder, 0777);
        }
        $fileName = $processFolder . DIRECTORY_SEPARATOR . microtime(true) . '-' . rand() . '.json';

        file_put_contents($fileName, json_encode($item));
    }

    protected function getProcessFolder($processId)
    {
        return $this->folder . DIRECTORY_SEPARATOR . $processId;
    }
}