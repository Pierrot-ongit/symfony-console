<?php

namespace Port\Console;

use Port\Writer;
use Port\Writer\WriterTemplate;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Igor Mukhin <igor.mukhin@gmail.com>
 */
class ConsoleTableWriter implements Writer
{
    use WriterTemplate;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var Table
     */
    private $table;

    /**
     * @var array
     */
    private $firstItem;

    /**
     * @param OutputInterface $output
     * @param Table           $table
     */
    public function __construct(OutputInterface $output, Table $table) {
        $this->output = $output;
        $this->table = $table;
    }

    /**
     * {@inheritdoc}
     */
    public function writeItem(array $item) {

        // Save first item to get keys to display at header
        if (is_null($this->firstItem)) {
            $this->firstItem = $item;
        }

        $this->table->addRow($item);
    }

    /**
     * {@inheritdoc}
     */
    public function finish() {
        $this->table->setHeaders(array_keys($this->firstItem));
        $this->table->render();

        $this->firstItem = null;
    }

    /**
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }
}
