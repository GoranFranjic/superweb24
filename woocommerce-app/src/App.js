import React, { useEffect, useState } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';

function App() {
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const apiUrl = 'https://superweb24.eu/wp-json/wc/v3/products';
  const consumerKey = 'ck_16e571a3a8827aabf7fe22329d82664924a90b93';
  const consumerSecret = 'cs_9b137e4e43e357e1d27220683ba71bbc7150350a';

  useEffect(() => {
    const fetchProducts = async () => {
      try {
        const response = await fetch(apiUrl, {
          headers: {
            'Authorization': 'Basic ' + btoa(`${consumerKey}:${consumerSecret}`)
          }
        });

        if (!response.ok) {
          throw new Error('Greška pri dohvaćanju podataka');
        }

        const data = await response.json();
        setProducts(data);
        setLoading(false);
      } catch (error) {
        setError(error.message);
        setLoading(false);
      }
    };

    fetchProducts();
  }, []);

  if (loading) {
    return <div className="text-center mt-5">Učitavanje...</div>;
  }

  if (error) {
    return <div className="text-center mt-5 text-danger">Greška: {error}</div>;
  }

  return (
    <div className="container mt-5">
      <h1 className="text-center mb-4">Proizvodi</h1>
      <div className="row">
        {products.map(product => (
          <div key={product.id} className="col-md-4 mb-4">
            <div className="card">
              <img
                src={product.images[0]?.src || 'https://via.placeholder.com/300'}
                className="card-img-top"
                alt={product.name}
              />
              <div className="card-body">
                <h5 className="card-title">{product.name}</h5>
                <p className="card-text" dangerouslySetInnerHTML={{ __html: product.short_description }}></p>
                <p className="card-text"><strong>Cijena:</strong> {product.price} €</p>
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}

export default App;