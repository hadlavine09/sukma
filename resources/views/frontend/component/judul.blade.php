<style>
        .split-hero {
            display: flex;
            min-height: 500px;
            box-shadow: 0 15px 8px rgba(0, 0, 0, 0.1);
        }

        .left-side {
            flex: 1;
            background-color: #f5f6ef;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-side {
            flex: 1;
            padding: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to bottom right, #80a78a 0%, #6FA36F 30%, #2d5727 100%);
        }


        .left-side h1 {
            font-size: 2.5rem;
            color: #1b4d3e;
            margin-bottom: 1rem;
        }

        .left-side p {
            font-size: 1rem;
            color: #444;
            margin-bottom: 1.5rem;
        }

        .cta-btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #3c9d40;
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            max-width: fit-content;
        }

        .right-side img {
            max-width: 100%;
            height: auto;
            border-radius: 1rem;
        }
    </style>
    <section class="split-hero">
        <div class="left-side">
            <h1>Eusc Frendily <br> Preccincercy</h1>
            <p>Loereth bssumrutiohen amametr, erers, crasmctcoeciensticsiplär cerealbaiub di nudjioptent ershufadt...
            </p>
            <a href="#" class="cta-btn">LEERES UMAR-UP CLICK</a>
        </div>
        <div class="right-side">
            <img src="{{ asset('assets_frontend/images/hero-img-1.png') }}" alt="Eco Products">
        </div>
    </section>
