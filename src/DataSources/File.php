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
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class File implements DataSourceInterface
{
    /**
     * @var string
     */
    protected $folder;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * File constructor.
     */
    public function __construct($outputFolder)
    {
        $this->folder = $outputFolder;

        $this->filesystem = new Filesystem();
    }

    /**
     * @param $processId
     * @return \Generator
     * @throws \InvalidArgumentException
     */
    public function getProcess($processId)
    {
        $finder = new Finder();
        $iterator = $finder
            ->name('*.json')
            ->sortByName()
            ->in($this->getProcessFolder($processId));

        /** @var SplFileInfo $file */
        foreach ($iterator as $file) {
            yield file_get_contents($file->getPath() . DIRECTORY_SEPARATOR . $file->getFilename());
        }
    }

    /**
     * @throws IOException
     */
    public function clear()
    {
        $finder = new Finder();
        $this->filesystem->remove($finder->in($this->folder));
    }

    /**
     * @throws IOException
     * @throws \InvalidArgumentException
     */
    public function deleteProcess($processId)
    {
        $finder = new Finder();
        $this->filesystem->remove($finder->in($this->getProcessFolder($processId)));
    }

    /**
     * @param Process $process
     * @param array $item
     * @throws IOException
     */
    public function save(Process $process, array $item)
    {
        $processFolder = $this->getProcessFolder($process->getId());

        if (!is_dir($processFolder)) {
            $this->filesystem->mkdir($processFolder, 0777);
        }
        $fileName = $processFolder . DIRECTORY_SEPARATOR . microtime(true) . '-' . rand() . '.json';

        file_put_contents($fileName, json_encode($item));
    }

    /**
     * @param $processId
     * @return string
     */
    protected function getProcessFolder($processId)
    {
        return $this->folder . DIRECTORY_SEPARATOR . $processId;
    }
}
