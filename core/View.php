<?php

declare(strict_types=1);

class View
{

  public function render()
  {
    $content = $this->loadContent('page.home');
    echo $this->loadLayout($content);
  }

  private function loadLayout($viewContent = null)
  {
    $layoutPath = LAYOUT_PATH . 'default.php';
    if (!is_file($layoutPath)) {
      throw new RuntimeException("Layout file not found: $layoutPath");
    }

    // Capture layout output with PHP execution
    ob_start();
    // Make $viewContent available as a variable in the layout
    $content = (string)$viewContent;
    include $layoutPath;
    $layoutContent = ob_get_clean();
    
    // Replace @content placeholder if it exists
    $layoutContent = str_replace('@content', $content, $layoutContent);
    $layoutContent = $this->loadComponents($layoutContent);
    $layoutContent = $this->loadComponents($layoutContent); # Doppelt, damit component auch componente nutzen können
    
    return $layoutContent;
  }

  private function loadContent($viewName)
  {
    $viewPath = VIEW_PATH . str_replace('.', '/', $viewName) . '.php';
    if (!is_file($viewPath)) {
      throw new RuntimeException("View file not found: $viewPath");
    }

    // Execute PHP and capture output
    ob_start();
    include $viewPath;
    return ob_get_clean();
  }


  private function loadComponents($content)
  {
    return preg_replace_callback('/@comp:([a-zA-Z0-9_.-]+)(?:\((.*?)\))?/', function ($matches) {
      $componentName = $matches[1];
      $params = isset($matches[2]) ? $matches[2] : '';
      
      $componentPath = COMPONENT_PATH . str_replace('.', '/', $componentName) . '.php';
      if (is_file($componentPath)) {
        // Parse simple parameters if provided
        $variables = [];
        if (!empty($params)) {
          // Simple parameter parsing: key=value,key2=value2
          $pairs = explode(',', $params);
          foreach ($pairs as $pair) {
            $parts = explode('=', trim($pair), 2);
            if (count($parts) === 2) {
              $key = trim($parts[0]);
              $value = trim($parts[1], '"\''); // Remove quotes
              $variables[$key] = $value;
            }
          }
        }
        
        // Extract variables to scope
        extract($variables, EXTR_SKIP);
        
        ob_start();
        include $componentPath;
        return ob_get_clean();
      } else {
        return "<!-- Component not found: $componentName -->";
      }
    }, $content);
  }
}
