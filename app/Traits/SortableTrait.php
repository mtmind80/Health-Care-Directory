<?php

trait SortableTrait
{
    public abstract function sortableColumns();



    public function scopeSortable($query, $defaultFieldOrder = false, $defaultTypeOrder = 'asc')
    {
        if (Input::has('f') && Input::has('o') && in_array(Input::get('f'), $this->sortableColumns())) {
            if (strpos(Input::get('f'), '|')) {
                list($main, $related) = explode('|', Input::get('f'));
                list($table, $field) = explode('.', $main);
                list($join, $foreign) = explode('.', $related);

                return $query->join($table, $join . '.' . $foreign, '=', $table .'.id')
                    ->orderBy($table . '.' . $field, Input::get('o'))
                    ->select([$join.'.*']);

            } else {
                return $query->orderBy(Input::get('f'), Input::get('o'));
            }
        } else if ($defaultFieldOrder) {
            $query->orderBy($defaultFieldOrder, $defaultTypeOrder);
        } else {
            return $query;
        }
        /*
        $query->join('categories', 'news.category_id', '=', 'categories.id')
            ->orderBy('categories.name_en', 'asc')
            // with('category') if we need to get related categories, uncomment
            ->select(['news.*']);
        */
    }

    /** for table column headers */
    public static function link($col, $title = null, $query = [])
    {
        if (is_null($title)) {
            $title = str_replace('_', ' ', $col);
            $title = ucfirst($title);
        }

        $indicator = (Input::get('f') == $col ? (Input::get('o') === 'asc' ? '&uarr;' : '&darr;') : null);
        $parameters = array_merge($query, Input::get(), array('f' => $col, 'o' => (Input::get('o') === 'asc' ? 'desc' : 'asc')));

        return link_to_route(Route::currentRouteName(), "$title $indicator", $parameters);
    }

    /** toggle button */
    public static function orderLink($fieldName, $params)
    {
        if (!is_null($params['text'])) {
            $text = $params['text'];
        } else {
            $text = str_replace('_', ' ', $fieldName);
            $text = ucfirst($text);
        }
        $query = (!empty($params['query'])) ? $params['query'] : [];

        $class = (!empty($params['class'])) ? ' class="' . $params['class'] . '"' : '';
        $title = (!empty($params['title'])) ? ' title="' . $params['title']  . '"' : '';

        $indicator = (Input::get('f') == $fieldName ? (Input::get('o') === 'asc' ? ' <i class="fa fa-sort-amount-asc ml5 m_right_0"></i>' : ' <i class="fa fa-sort-amount-desc ml5 m_right_0"></i>') : null);
        $parameters = array_merge($query, Input::get(), array('f' => $fieldName, 'o' => (Input::get('o') === 'asc' ? 'desc' : 'asc')));

        return '<a href="' . route(Route::currentRouteName(), $parameters) . '"' . $class . $title . '>' . $text . $indicator . '</a>';
    }

    /** for one direction  buttons */
    public static function fixedOrderLink($col, $direction, $title = null, $query = [])
    {
        if (is_null($title)) {
            $title = '&nbsp;';
        }
        $direction = strtolower($direction);
        if ($direction != 'asc' && $direction != 'desc') {
            $direction = 'asc';
        }
        $parameters = array_merge($query, Input::get(), array('f' => $col, 'o' => $direction));

        return link_to_route(Route::currentRouteName(), "$title", $parameters);
    }

    public static function fixedOrderRoute($col, $direction = 'asc', $query = [])
    {
        $direction = strtolower($direction);
        if ($direction != 'asc' && $direction != 'desc') {
            $direction = 'asc';
        }
        $parameters = array_merge($query, Input::get(), array('f' => $col, 'o' => $direction));

        return route(Route::currentRouteName(), $parameters);
    }

}