<?php

namespace App\Console\Commands;

use App\Form;
use Illuminate\Console\Command;

class FormsGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forms:generate {count=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates forms';

    /**
     * @var Form
     */
    protected $forms;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Form $forms)
    {
        parent::__construct();

        $this->forms = $forms;
    }

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle()
    {
        $count = $this->validateAndGetCount();
        for ($i = 0; $i < $count; ++$i) {
            $form = new Form();
            $form->setRawAttributes([
                'name' => uniqid(),
                'data' => $this->getFormData(),
                'step_id' => 1,
            ]);
            if ($form->save()) {
                dump("Form {$form->name} saved");
            } else {
                dump('Form not saved');
            }
        }

        dump('done');
    }

    private function validateAndGetCount()
    {
        $count = $this->argument('count');
        if (!is_numeric($count)) {
            throw new \Exception('Argument have to be numeric');
        }

        return $count;
    }

    private function getFormData()
    {
        return '{"sections":[{"name":"section_52789","label":null,"clientKey":"section_52789","order":0,"rows":[{"name":"section_52789_row_182606","label":null,"order":0,"controls":[{"type":"text","name":"control_text_602102","fieldName":"control_text_602102","label":"HELLO","order":0,"defaultValue":null,"value":null,"className":"col-md-4","readonly":false,"labelBold":false,"labelItalic":false,"labelUnderline":false,"required":false,"isMultiLine":false,"isInteger":false,"decimalPlace":0,"isTodayValue":false,"dateFormat":"dd\/mm\/yy","isNowTimeValue":false,"timeFormat":"HH:mm","isMultiple":false,"isAjax":false,"dataOptions":[],"ajaxDataUrl":null,"isChecked":false}]}],"labelPosition":"left","isDynamic":false,"minInstance":1,"maxInstance":0,"instances":[]}],"layout":"collapse","_uniqueId":0.9890472454308146}';
    }
}
