# Global-Api-Criteria
## Examples
```bash
php index.php \
    --orm=eloquent \
    --filter="price > 100 and price < 400" \
    --order='price asc' \
    --paginate='0, 3'
```

## Help

```
--orm
    Type: string
    Default: doctrine
    Accept values: doctrine|eloquent|array

--filter
    Type: string|null
    Default: null
    Accept values: FilterGroup deserialize syntax.

--order
    Type: string|null
    Default: null
    Accept values: OrderGroup deserialize syntax.

--paginate
    Type: string|null
    Default: null
    Accept values: Paginate deserialize syntax (offset, limit).
