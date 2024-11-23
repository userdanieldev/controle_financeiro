CREATE SCHEMA pobretao;

CREATE TABLE month (
    id INT PRIMARY KEY AUTO_INCREMENT,
    month_date DATE NOT NULL
);

CREATE TABLE transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    type ENUM('Saida', 'Entrada') NOT NULL,
    value DECIMAL(10, 2) NOT NULL,
    date DATE NOT NULL,
    month_id INT,
    FOREIGN KEY (month_id) REFERENCES month(id)
);

INSERT INTO month (month_date)
VALUES 
('2024-01-01'),
('2024-02-01'),
('2024-03-01'),
('2024-04-01'),
('2024-05-01'),
('2024-06-01'),
('2024-07-01'),
('2024-08-01'),
('2024-09-01'),
('2024-10-01');

INSERT INTO transactions (name, category, type, value, date, month_id)
VALUES 
-- Janeiro
('Salário', 'Renda', 'Entrada', 5000.00, '2024-01-10', 1),
('Plano de Saúde', 'Saúde', 'Saida', 350.00, '2024-01-12', 1),
('Cinema', 'Lazer', 'Saida', 50.00, '2024-01-20', 1),
('Internet', 'Serviços', 'Saida', 120.00, '2024-01-22', 1),
('Restituição IR', 'Renda Extra', 'Entrada', 800.00, '2024-01-25', 1),

-- Fevereiro
('Salário', 'Renda', 'Entrada', 5000.00, '2024-02-10', 2),
('Energia Elétrica', 'Serviços', 'Saida', 200.00, '2024-02-05', 2),
('Roupa', 'Compras', 'Saida', 300.00, '2024-02-10', 2),
('Investimento', 'Renda', 'Entrada', 1000.00, '2024-02-15', 2),
('Jantar', 'Lazer', 'Saida', 150.00, '2024-02-20', 2),

-- Março
('Salário', 'Renda', 'Entrada', 5000.00, '2024-03-10', 3),
('Escola', 'Educação', 'Saida', 600.00, '2024-03-05', 3),
('Reembolso', 'Renda Extra', 'Entrada', 300.00, '2024-03-10', 3),
('Streaming', 'Serviços', 'Saida', 45.00, '2024-03-15', 3),
('Farmácia', 'Saúde', 'Saida', 250.00, '2024-03-25', 3),

-- Abril
('Salário', 'Renda', 'Entrada', 5000.00, '2024-04-10', 4),
('Viagem', 'Lazer', 'Saida', 2000.00, '2024-04-03', 4),
('Dividendo', 'Renda Extra', 'Entrada', 1500.00, '2024-04-08', 4),
('Gasolina', 'Transporte', 'Saida', 300.00, '2024-04-12', 4),
('Café', 'Alimentação', 'Saida', 30.00, '2024-04-15', 4),

-- Maio
('Salário', 'Renda', 'Entrada', 5000.00, '2024-05-10', 5),
('Manutenção Carro', 'Transporte', 'Saida', 800.00, '2024-05-05', 5),
('Venda de Roupas', 'Renda Extra', 'Entrada', 600.00, '2024-05-10', 5),
('Cursos Online', 'Educação', 'Saida', 450.00, '2024-05-20', 5),
('Supermercado', 'Alimentação', 'Saida', 700.00, '2024-05-25', 5),

-- Junho
('Salário', 'Renda', 'Entrada', 5000.00, '2024-06-10', 6),
('Hospedagem', 'Lazer', 'Saida', 1200.00, '2024-06-05', 6),
('Promoção', 'Renda Extra', 'Entrada', 900.00, '2024-06-08', 6),
('Livros', 'Educação', 'Saida', 350.00, '2024-06-15', 6),
('Supermercado', 'Alimentação', 'Saida', 800.00, '2024-06-20', 6),

-- Julho
('Salário', 'Renda', 'Entrada', 5000.00, '2024-07-10', 7),
('Hotel', 'Lazer', 'Saida', 1500.00, '2024-07-04', 7),
('Venda de Bicicleta', 'Renda Extra', 'Entrada', 1200.00, '2024-07-15', 7),
('Assinatura Digital', 'Serviços', 'Saida', 100.00, '2024-07-20', 7),
('Farmácia', 'Saúde', 'Saida', 200.00, '2024-07-25', 7),

-- Agosto
('Salário', 'Renda', 'Entrada', 5000.00, '2024-08-10', 8),
('Manutenção Casa', 'Serviços', 'Saida', 300.00, '2024-08-05', 8),
('Bônus', 'Renda Extra', 'Entrada', 700.00, '2024-08-12', 8),
('Passeio', 'Lazer', 'Saida', 250.00, '2024-08-18', 8),
('Supermercado', 'Alimentação', 'Saida', 750.00, '2024-08-22', 8),

-- Setembro
('Salário', 'Renda', 'Entrada', 5000.00, '2024-09-10', 9),
('Seguro Carro', 'Transporte', 'Saida', 1300.00, '2024-09-05', 9),
('Freelance', 'Renda Extra', 'Entrada', 1100.00, '2024-09-10', 9),
('Ginástica', 'Saúde', 'Saida', 200.00, '2024-09-15', 9),
('Assinatura de Streaming', 'Serviços', 'Saida', 50.00, '2024-09-22', 9),

-- Outubro
('Salário', 'Renda', 'Entrada', 5000.00, '2024-10-10', 10),
('Conserto Eletrônico', 'Serviços', 'Saida', 400.00, '2024-10-05', 10),
('Promoção de Produtos', 'Renda Extra', 'Entrada', 950.00, '2024-10-08', 10),
('Cinema', 'Lazer', 'Saida', 60.00, '2024-10-20', 10),
('Mercado', 'Alimentação', 'Saida', 820.00, '2024-10-25', 10);