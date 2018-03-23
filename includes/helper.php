<?php
/*
 * render() - Renders the template
 *
 * @param string $template - The name of the template to render.
 * @param array $data - An array of variables and values to pass to the template.
 */
function render($template, $data = array())
{
    $path = __DIR__ . '/../view/' . $template . '.php';
	if (file_exists($path))
    {
        extract($data);
        require($path);
    }
}

?>
