<?php

namespace OmniSmtp\Util;

use Exception;
use OmniSmtp\Common\TemplateVarInterface;
use Symfony\Component\Filesystem\Filesystem;

class TemplateHelper
{


    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    protected $filesystem;

    public function __construct(Filesystem $filesystem = null)
    {
        $this->filesystem = $filesystem ?? new Filesystem();
    }

    /**
     * Build template
     * 
     * @param string $template_path
     * @param array $data
     *
     * @return string
     */
    public function build(string $template_path, $templateVar = null)
    {
        $this->templateMustExist($template_path);

        $variables = [];
        
        if ($templateVar instanceof TemplateVarInterface) {
            $variables['tpl'] = $templateVar;
        } else if (is_array($templateVar) && count($templateVar) > 0) {
            $variables = array_replace($variables, $templateVar);
        }

        return call_user_func(function(){

            if ($templateVar = func_get_arg(1)) {
                extract($templateVar);
            }

            ob_start();
            // get the template
            require func_get_arg(0);

            return ob_get_clean();

        }, $template_path, $templateVar);
    }

    /**
     * Make sure template exists
     *
     * @param string $template_path
     * 
     * @return void
     * 
     * @throws \Exception
     */
    protected function templateMustExist(string $template_path)
    {
        if (!$this->filesystem->exists($template_path)) {
            throw new Exception(sprintf("The template %s does not exist.", $template_path));
        }
    }
}