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

/**
 * Class File
 * @package Ndrx\Profiler\DataSources
 */
class File implements DataSourceInterface
{
    const SUMMARY_FILENAME = 'summary.json';

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
            ->notContains('summary.json')
            ->sortByName()
            ->in($this->getProcessFolder($processId));

        /** @var SplFileInfo $file */
        foreach ($iterator as $file) {
            yield file_get_contents($file->getPath() . DIRECTORY_SEPARATOR . $file->getFilename());
        }
    }

    /**
     * @throws IOException
     * @throws \InvalidArgumentException
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
        $this->filesystem->remove($this->getProcessFolder($processId));
    }

    /**
     * @param Process $process
     * @param array $item
     * @throws IOException
     * @return bool
     */
    public function save(Process $process, array $item)
    {
        $fileName = $this->getProcessFolder($process->getId())
            . DIRECTORY_SEPARATOR . microtime(true)
            . '-' . rand() . '.json';

        return file_put_contents($fileName, json_encode($item)) !== false;
    }

    /**
     * @param $processId
     * @return string
     * @throws IOException
     */
    protected function getProcessFolder($processId)
    {
        $processFolder = $this->folder . DIRECTORY_SEPARATOR . $processId;

        if (!is_dir($processFolder)) {
            $this->filesystem->mkdir($processFolder, 0777);
        }

        return $processFolder;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @throws IOException
     * @throws \InvalidArgumentException
     * @throws \LogicException
     * @return array
     */
    public function all($offset = 0, $limit = 15)
    {
        $finder = new Finder();
        $iterator = $finder
            ->directories()
            ->depth(0)
            ->sortByModifiedTime()
            ->in($this->folder)
            ->getIterator();


        $processFiles = array_slice(iterator_to_array($iterator), $offset, $limit);

        $process = [];
        /** @var SplFileInfo $current */
        foreach ($processFiles as $current) {

            $summaryFile = $current->getPath() . DIRECTORY_SEPARATOR
                . $current->getFilename() . DIRECTORY_SEPARATOR
                . self::SUMMARY_FILENAME;

            if ($this->filesystem->exists($summaryFile)) {
                $process[] = json_decode(file_get_contents($summaryFile));
            }
        }

        return $process;
    }

    /**
     * @return int
     * @throws IOException
     * @throws \InvalidArgumentException
     */
    public function count()
    {
        $finder = new Finder();

        return  $finder
            ->directories()
            ->depth(0)
            ->in($this->folder)
            ->count();
    }

    /**
     * @param Process $process
     * @param array $item
     * @return mixed
     * @throws IOException
     */
    public function saveSummary(Process $process, array $item)
    {
        $fileName = $this->getProcessFolder($process->getId())
            . DIRECTORY_SEPARATOR . self::SUMMARY_FILENAME;

        return file_put_contents($fileName, json_encode($item)) !== false;
    }
}
