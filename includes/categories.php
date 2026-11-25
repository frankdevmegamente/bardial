<?php
/**
 * Categorías canónicas del sitio (según bardial-diseno-spec.md).
 * Los tipos históricos de la BD se mapean internamente a estas 4 categorías
 * para no perder propiedades ni alterar los datos reales.
 */
define('BARDIAL_CATEGORIES', ['Casa residencial', 'Bodega', 'Local comercial', 'Departamento']);

function bardial_category_for($type): string
{
    $t = mb_strtolower(trim((string)$type));

    if (str_contains($t, 'departamento') || str_contains($t, 'penthouse')) {
        return 'Departamento';
    }
    if (str_contains($t, 'bodega')) {
        return 'Bodega';
    }
    if (str_contains($t, 'local')) {
        return 'Local comercial';
    }

    // Casa Residencial, Mansión, Casona Colonial, Hacienda, Villa, Casa de Playa...
    return 'Casa residencial';
}

/**
 * Añade el campo `category` a cada propiedad (útil para el JSON del modal).
 */
function bardial_with_categories(array $properties): array
{
    foreach ($properties as &$p) {
        $p['category'] = bardial_category_for($p['type'] ?? '');
    }
    unset($p);
    return $properties;
}
