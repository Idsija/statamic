---
id: a6dad553-e20f-4931-902c-f6a2fb87939d
blueprint: page
title: Samples
author: fb795642-784f-4274-b19c-47658a1de722
updated_by: fb795642-784f-4274-b19c-47658a1de722
updated_at: 1701679269
bard_field:
  -
    type: heading
    attrs:
      level: 2
    content:
      -
        type: text
        text: Collection
  -
    type: set
    attrs:
      id: lpmojmsh
      values:
        type: collection
        collections_field: blogs
  -
    type: heading
    attrs:
      level: 3
    content:
      -
        type: text
        text: 'Command: php please make: CollectionQuery '
  -
    type: heading
    attrs:
      level: 3
    content:
      -
        type: text
        text: 'Creates: App/Tags/CollectionQuery.php (example code below)'
  -
    type: set
    attrs:
      id: lpmryom7
      values:
        type: code
        code_field: |
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
  -
    type: paragraph
aside_bard_field:
  -
    type: heading
    attrs:
      level: 2
    content:
      -
        type: text
        text: Filter
  -
    type: set
    attrs:
      id: lpqner9k
      values:
        type: filter
        taxonomies_field:
          - category
          - location
  -
    type: paragraph
---
