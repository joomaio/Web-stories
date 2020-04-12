import React from "react";
import { Link } from "react-router-dom";

const Footer = () => {
  return (
    <footer className="text-muted">
      <div className="container">
        <p className="float-right">
          <Link onClick={() => window.scrollTo(0, 0)}>Back to top</Link>
        </p>
        <p>2020 © Webstories</p>
      </div>
    </footer>
  );
};

export default Footer;
