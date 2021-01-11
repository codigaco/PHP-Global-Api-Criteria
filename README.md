# Global-Api-Criteria

**Example:**
`
$productCriteria = ProductCriteriaExample::create()
     ->withFilter(FilterGroup::deserialize('(name like computer or name like pc) and price > 500 and price <= 1000'))
     ->withOrder(OrderGroup::deserialize('price asc, stock desc'))
     ->withPaginate(Paginate::create(0, 5));
`