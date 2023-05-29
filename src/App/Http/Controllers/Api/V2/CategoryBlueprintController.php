<?php

namespace App\Http\Controllers\Api\V2;

use Domain\Content\Models\Category;
use Illuminate\Database\Connection;
use App\Http\Controllers\Controller;
use Doctrine\DBAL\Schema\Column;
use Domain\Content\Data\CategoryData;
use Illuminate\Database\ConnectionResolverInterface;

/**
 * @group Category management V2
 */
class CategoryBlueprintController extends Controller
{
    public function __invoke(ConnectionResolverInterface $connections)
    {
        /** @var Connection $connection */
        $connection = $connections->connection();
        $schema = $connection->getDoctrineSchemaManager();
        $table = $schema->introspectTable((new Category)->getTable());
        $columns = collect($table->getColumns())->filter(fn (Column $column, $key) => ! in_array($key, ['id', 'ulid']));
        $columns = $columns->map(fn (Column $column) => [
            'column' => $column->getName(),
            'is_nullable' => ! $column->getNotNull(),
            'default' => $column->getDefault(),
            'type' => $column->getType()->getName(),
        ]);

        return response()->json([
            'sample' => CategoryData::empty(),
            'attributes' => $columns->toArray(),
        ]);
    }
}
