<?php

error_reporting(-1);

function dd($data)
{
    echo '<pre>' . print_r($data, 1) . '</pre>';
}

$dsn = "mysql:host=localhost;dbname=test;charset=utf8";

$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

$pdo = new PDO($dsn, 'root', '', $opt);

$stmt = $pdo->prepare("SELECT * FROM categories");
$stmt->execute();

while ($row = $stmt->fetch()) {
    $data[$row['id']] = $row;
}

function getTree($data)
{
    $i = $i ?? 0;
    $tree = [];
    foreach ($data as $id => &$node) {
        if (!$node['parent_id']) {
            $tree[$id] =& $node; 
        } else {
            $data[$node['parent_id']]['children'][$id] =& $node;
        }
        
        $i++;
    }
    return $tree;
}

function buildMenuList($tree)
{
    $html = '<ul>' . "\n";
    
    foreach ($tree as $item) {
        $html .= "<li>" . "\n";
        $html .= "<a href=\"{$item['id']}\">{$item['title']}</a>" . "\n";
        if (isset($item['children'])) {
            $html .= buildMenuList($item['children']);
        }
        $html .= "</li>" . "\n";
    }
    
    return $html . '</ul>';
}

function buildMenuSelect($tree, $tab = '')
{
    $html = '';
    
    foreach ($tree as $item) {
        $html .= "<option value=\"{$item['id']}\">" . $tab . " {$item['title']}</option>" . "\n";
        if (isset($item['children'])) {
            $html .= buildMenuSelect($item['children'], $tab . '--');
        }
    }
    
    return $html;
}

echo '<select>' . "\n";
echo buildMenuSelect(getTree($data));
echo '</select>';