import React from 'react';

function Products({ books }) {
  return (
    <div className="row">
   
      {books.map(book => (
        <div className="col-md-3 col-6 mb-4" key={book.id}>
          <div className="card">
            <img src={book.image} alt={book.name} className="card-img-top" />
            <div className="card-body">
              <h4 className="card-title">{book.name}</h4>
              <p>{book.author}</p>
              <p className="card-text">
                <strong>Price: </strong> ${book.price}
              </p>
              <p className="btn-holder">
                <a href={route("addbook.to.cart", book.id)} className="btn btn-outline-danger">
                  Add to cart
                </a>
              </p>
            </div>
          </div>
        </div>
      ))}
    </div>
  );
}

export default Products;
