<?php

namespace App\Tags;

use Statamic\Facades\Entry;
use Statamic\Facades\Taxonomy;
use Statamic\Support\Arr;
use Statamic\Tags\Concerns;
use Statamic\Tags\Tags;

class CollectionQuery extends Tags{
    use Concerns\OutputsItems;

    public function index(){
        $collection = Entry::query()->where('collection', $this->params->get('collection'));
        $parameters = Arr::sanitize($this->context->get('get'));
        $logic = $this->params->get('logic');

        if ($logic === 'or') {
            $filters = [];

            foreach ($parameters as $key => $value) {
                if (Taxonomy::handleExists($key) && is_array($value)) {
                    foreach ($value as $subValue) {
                        $filters[] = "$key::$subValue";
                    }
                }
            }

            if($filters){
                $collection = $collection->whereTaxonomyIn($filters);
            }

        }else if ($logic === 'and'){

            foreach ($parameters as $key => $value) {
                if (Taxonomy::handleExists($key) && is_array($value)) {
                    foreach ($value as $subValue) {
                        $collection = $collection->whereTaxonomy("$key::$subValue");
                    }
                }
            }

        }

        return $this->output($collection);
    }

    // The {{ collection_query:pages }} tag.
    /*    public function pages()
    {
        $pages = Entry::query()->where('collection', 'pages');
        return $this->output($pages);
    }*/
}
