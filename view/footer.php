<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  html,
  body {
    height: 100%;
  }

  #sticky-footer {
    position:fixed;
    bottom: 0;
    width: 100%;
    text-align: center;
    
    padding: 1px;
    z-index: 1;
  }

  @media (max-width: 576px) {
    #sticky-footer {
      padding: 10px;
    }
  }
</style>

<body>


<footer id="sticky-footer" class="text-dark-50 bg-primary d-flex">
    <div class="container text-center ">
      <h5 class="my-2">&copy; 2023 E-library</h5> 
    </div>
  </footer>
</body>