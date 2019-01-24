<?php
namespace Vitvik\Blog\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $data = [
            ['title' => 'Lorem ipsum',
            'content' => 'Lorem ipsum, in graphical and textual context, refers to filler text that is placed in a document or visual presentation. Lorem ipsum is derived from the Latin "dolorem ipsum" roughly translated as "pain itself." Lorem ipsum presents the sample font and orientation of writing on Web pages and other software applications where content is not the main concern of the developer.'
            ],
            ['title' => 'Techopedia explains ',
            'content' => 'Techopedia explains Lorem Ipsum Lorem ipsum is the nonsense filler text that typically demonstrates the font and style of a text in a document or visual demonstration. Originally from Latin, lorem ipsum has no intelligible meaning, but is simply a display of letters and characteristics to be viewed as a sample with given graphical elements in a file. '
            ],
            ['title' => 'Lipsum',
            'content' => 'Lipsum (portmanteau of lorem and ipsum) generators are commonly used to form generic text in a file. The “gibberish” is adequately like normal text to demonstrate a font, but does not distract the reader with its content. It has been used as placeholder text since the 16th century. '
            ],
            ['title' => 'Originally from Latin',
            'content' => 'Originally from Latin, lorem ipsum has no intelligible meaning, but is simply a display of letters and characteristics to be viewed as a sample with given graphical elements in a file. '
            ]
        ];
        foreach ($data as $bind) {
            $setup->getConnection()
                ->insertForce($setup->getTable('vitvik_blog_post'), $bind);
        }
    }
}