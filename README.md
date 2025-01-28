## Magpie PHP Developer Challenge (Solution)

1. Get the document with the crawler 
2. Target the page links by id
3. Loop over page links to obtain products per page
4. Loop over the products to retrieve product data 
5. Retrieve variants, loop variants to determine new products 
6. Assign uuid for variant based on **title**, **colour** and **capacity**.
7. Prevent duplicates when calling array_merge()
8. Pass array of Product objects to presenter, format correctly and return a json array.

The solution was written with a variety of architectural patterns to allow for scalability, as seen formatting data can quickly become messy. Extracting this logic makes the code more readable. Using use cases to extract logic allows for nicer debugging. Making use of the factory pattern to build the object and use as a data transfer object (DTO).
## Improvements 
-  Tests to be written to ensure functions return expected results based on mock input 
- Could potentially write tests to ensure correct data nodes returned from crawler, however if we don't have control over the html this could become more time consuming then beneficial.
- Look at the performance of foreach loops and perhaps migrate to a for based on pages length. 

