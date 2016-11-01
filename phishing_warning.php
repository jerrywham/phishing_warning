<?php
/**
 * phishing_warning plugin
 *
 * Demo page for warning user about target="_blank" vunerability
 */

/*
 * RENDER HEADER, INCLUDES, FOOTER
 *
 * Those hooks are called at every page rendering.
 * You can filter its execution by checking _PAGE_ value
 * and check user status with _LOGGEDIN_.
 */

/**
 * Hook render_includes.
 * Executed on every page rendering.
 *
 * Template placeholders:
 *   - css_files
 *
 * Data:
 *   - _PAGE_: current page
 *   - _LOGGEDIN_: true/false
 *
 * @param array $data data passed to plugin
 *
 * @return array altered $data.
 */
function hook_phishing_warning_render_includes($data)
{
    // List of plugin's CSS files.
    // Note that you just need to specify CSS path.
    if (isset($_GET['phishing'])) {
        $data['css_files'][] = PluginManager::$PLUGINS_PATH . '/phishing_warning/phishing_warning.css';
    }
    return $data;
}

/**
 * Hook render_footer.
 * Executed on every page redering.
 *
 * Template placeholders:
 *   - text
 *   - endofpage
 *   - js_files
 *
 * Data:
 *   - _PAGE_: current page
 *   - _LOGGEDIN_: true/false
 *
 * @param array $data data passed to plugin
 *
 * @return array altered $data.
 */
function hook_phishing_warning_render_footer($data)
{
    // footer text
    $data['text'][] = '';

    // Free elements at the end of the page.
    $data['endofpage'][] = '<script>' ."\n".
'// Phishing warning
  if (window.opener) {
    var url = document.createElement(\'a\');
    url.href = document.referrer;
    window.opener.location = "?phishing&referrer=" + url.hostname;
  }'."\n".'</script>';

    // List of plugin's JS files.
    // Note that you just need to specify CSS path.
    

    return $data;
}

/*
 * SPECIFIC PAGES
 */

/**
 * Hook render_linklist.
 *
 * @param array $data data passed to plugin
 *
 * @return array altered $data.
 */
function hook_phishing_warning_render_linklist($data)
{
    if (isset($_GET['phishing'])) {
        $phishing_warning_date = date('Ymd_his');
        $html = file_get_contents(PluginManager::$PLUGINS_PATH .'/phishing_warning/phishing_warning.html');
        $html = str_replace('{{referrer}}', ($_GET['referrer'] == $_SERVER['SERVER_NAME'] ? 'Site épinglé dans votre navigateur' : $_GET['referrer']), $html);
        $html = str_replace('{{SITE}}', 'http'.($_SERVER['SERVER_PROTOCOL'] != 'HTTP/1.1' ? 's' : '').'://'.$_SERVER['SERVER_NAME'], $html);
      // // Manipulate link data
        $data['links'] = array();
        $data['links'][$phishing_warning_date]['title'] = 'Alerte phishing !';
        $data['links'][$phishing_warning_date]['url'] = '';
        $data['links'][$phishing_warning_date]['description'] = $html;
        $data['links'][$phishing_warning_date]['private'] = 0;
        $data['links'][$phishing_warning_date]['linkdate'] = $phishing_warning_date;
        $data['links'][$phishing_warning_date]['tags'] = 'sécurité phishing';
        $data['links'][$phishing_warning_date]['real_url'] = 'https://blog.nathanaelcherrier.com/';
        $data['links'][$phishing_warning_date]['class'] = 'publicLinkHightLight';
        $data['links'][$phishing_warning_date]['timestamp'] = $_SERVER['REQUEST_TIME'];
        $data['links'][$phishing_warning_date]['taglist'] = array(0=> 'sécurité', 1 => 'phishing');
        $data['links'][$phishing_warning_date]['shorturl'] = '';
        $data['links'][$phishing_warning_date]['link_plugin'] = '';
    }
    return $data;
}

