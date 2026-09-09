
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Banco de dados: `projeto_agendamento_medico`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `atendimentos`
--

CREATE TABLE `atendimentos` (
  `id` int(11) NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `sintomas` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnostico` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observacoes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_atendimento` datetime DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `atestados`
--

CREATE TABLE `atestados` (
  `id` int(11) NOT NULL,
  `atendimento_id` int(11) NOT NULL,
  `dias_afastamento` int(11) NOT NULL,
  `cid` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observacoes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_emissao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `consultas`
--

CREATE TABLE `consultas` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `data_consulta` date NOT NULL,
  `horario` time NOT NULL,
  `hora_checkin` datetime DEFAULT NULL,
  `motivo_consulta` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Agendada','Em Andamento','Finalizada','Cancelada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Agendada',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `especialidades`
--

CREATE TABLE `especialidades` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `especialidades`
--

INSERT INTO `especialidades` (`id`, `nome`, `descricao`, `ativo`, `created_at`, `updated_at`) VALUES
(2, 'Orologista', 've saco', 1, '2026-08-12 17:21:06', '2026-08-12 18:05:13');

-- --------------------------------------------------------

--
-- Estrutura da tabela `horarios`
--

CREATE TABLE `horarios` (
  `id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `dia_semana` tinyint(4) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fim` time NOT NULL,
  `intervalo_minutos` int(11) NOT NULL DEFAULT 30,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ;

--
-- Extraindo dados da tabela `horarios`
--

INSERT INTO `horarios` (`id`, `medico_id`, `dia_semana`, `hora_inicio`, `hora_fim`, `intervalo_minutos`, `ativo`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '15:20:00', '16:00:00', 30, 1, '2026-08-19 17:10:57', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `medicos`
--

CREATE TABLE `medicos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `crm_numero` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `crm_uf` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `medicos`
--

INSERT INTO `medicos` (`id`, `usuario_id`, `crm_numero`, `crm_uf`, `telefone`, `ativo`, `created_at`, `updated_at`) VALUES
(1, 5, '123456', 'RS', '11999999999', 0, '2026-08-12 18:11:40', NULL),
(2, 6, '12345678', 'RS', '(51) 99907-3380', 0, '2026-08-12 18:12:21', NULL),
(3, 7, '876156', 'RS', '11999999999', 0, '2026-09-03 17:19:23', NULL),
(4, 8, '23183', 'RS', '5199999988', 0, '2026-09-03 17:47:31', NULL),
(5, 9, '422122', 'RS', '5417777777', 1, '2026-09-03 18:04:56', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `medicos_especialidades`
--

CREATE TABLE `medicos_especialidades` (
  `medico_id` int(11) NOT NULL,
  `especialidade_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `medicos_especialidades`
--

INSERT INTO `medicos_especialidades` (`medico_id`, `especialidade_id`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpf` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_nascimento` date NOT NULL,
  `sexo` enum('Masculino','Feminino','Outro') COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `endereco` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `convenio` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_sanguineo` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alergias` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observacoes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `pacientes`
--

INSERT INTO `pacientes` (`id`, `nome`, `cpf`, `data_nascimento`, `sexo`, `telefone`, `email`, `endereco`, `convenio`, `tipo_sanguineo`, `alergias`, `observacoes`, `ativo`, `created_at`, `updated_at`) VALUES
(1, 'João da Silva', '111.111.111-11', '2005-03-13', 'Masculino', '', '', '', '', 'A+', '', '', 1, '2026-08-17 17:59:59', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `receitas`
--

CREATE TABLE `receitas` (
  `id` int(11) NOT NULL,
  `atendimento_id` int(11) NOT NULL,
  `observacoes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `receita_itens`
--

CREATE TABLE `receita_itens` (
  `id` int(11) NOT NULL,
  `receita_id` int(11) NOT NULL,
  `medicamento` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dosagem` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frequencia` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duracao` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instrucoes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perfil` enum('Administrador','Recepcionista','Medico') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `primeiro_acesso` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `perfil`, `ativo`, `created_at`, `updated_at`, `primeiro_acesso`) VALUES
(1, 'Administrador', 'admin@admin.com', '$2y$10$G1cCSTkQc71Mf2GvQi.Y/eqxF7m.C6qCEXiOTZjSokuXiGO8DKT4W', 'Administrador', 1, '2026-07-20 17:46:22', NULL, 0),
(2, 'derick da silva vaz', 'deriquinhodosgrau@gmail.com', '$2y$10$RqQVWOeXEbzrMU.cfXQhIOPooRajA2RBwBW6QLjz1YTqA0.l56bHa', 'Recepcionista', 1, '2026-07-21 12:45:02', NULL, 0),
(5, 'Dr. João da Silva', 'joao.dsilva@gmail.com', '$2y$10$kXw/LLsGTtmiYMXDCKkD0u4vH9ZukjWgmyFTx3nlHiDLQjbWHzMe6', 'Medico', 1, '2026-08-12 18:11:40', NULL, 0),
(6, 'Fábio Júnior Gonçalves', 'goncalves.fb07@gmail.com', '$2y$10$pYsiTg9fQx.ZxkL1Oak2z.G8zeZFlYNcyUWOaiQ19SKq9pMJ0xb5K', 'Medico', 1, '2026-08-12 18:12:21', NULL, 0),
(7, 'teste medico', 'testemedico@gmail.com', '$2y$10$s1h/QGCZDl.Y9R.YuCyPPOV.BZxlWaq10B.g7s179PWDjLCpNMFPW', 'Medico', 1, '2026-09-03 17:19:22', NULL, 0),
(8, 'teste', 'teste@gmail.com', '$2y$10$Mgh6LucXC8yPl1fmTb1PyuhBFN4NvDDtTjHyXX8ieQN6YEvZYh.1u', 'Medico', 1, '2026-09-03 17:47:31', NULL, 0),
(9, 'teste1acesso', 'teste1acesso@gmail.com', '$2y$10$Su4BQdv7DPJNxmqCq2DO2eipBUMghWf8tTLFaT6I.CU7BiwmBfCUi', 'Medico', 1, '2026-09-03 18:04:56', NULL, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `atendimentos`
--
ALTER TABLE `atendimentos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `consulta_id` (`consulta_id`);

--
-- Índices para tabela `atestados`
--
ALTER TABLE `atestados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_atestado_atendimento` (`atendimento_id`);

--
-- Índices para tabela `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_consulta_paciente` (`paciente_id`),
  ADD KEY `fk_consulta_medico` (`medico_id`),
  ADD KEY `fk_consulta_usuario` (`usuario_id`),
  ADD KEY `idx_consulta_data` (`data_consulta`),
  ADD KEY `idx_consulta_status` (`status`);

--
-- Índices para tabela `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices para tabela `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_horarios_medico` (`medico_id`);

--
-- Índices para tabela `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_crm` (`crm_numero`,`crm_uf`),
  ADD KEY `fk_medico_usuario` (`usuario_id`);

--
-- Índices para tabela `medicos_especialidades`
--
ALTER TABLE `medicos_especialidades`
  ADD PRIMARY KEY (`medico_id`,`especialidade_id`),
  ADD KEY `fk_me_especialidade` (`especialidade_id`);

--
-- Índices para tabela `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD KEY `idx_paciente_nome` (`nome`),
  ADD KEY `idx_paciente_cpf` (`cpf`);

--
-- Índices para tabela `receitas`
--
ALTER TABLE `receitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_receita_atendimento` (`atendimento_id`);

--
-- Índices para tabela `receita_itens`
--
ALTER TABLE `receita_itens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_item_receita` (`receita_id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_usuario_email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `atendimentos`
--
ALTER TABLE `atendimentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `atestados`
--
ALTER TABLE `atestados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `receitas`
--
ALTER TABLE `receitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `receita_itens`
--
ALTER TABLE `receita_itens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `atendimentos`
--
ALTER TABLE `atendimentos`
  ADD CONSTRAINT `fk_atendimento_consulta` FOREIGN KEY (`consulta_id`) REFERENCES `consultas` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `atestados`
--
ALTER TABLE `atestados`
  ADD CONSTRAINT `fk_atestado_atendimento` FOREIGN KEY (`atendimento_id`) REFERENCES `atendimentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `consultas`
--
ALTER TABLE `consultas`
  ADD CONSTRAINT `fk_consulta_medico` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_consulta_paciente` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_consulta_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `fk_horarios_medico` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `medicos`
--
ALTER TABLE `medicos`
  ADD CONSTRAINT `fk_medico_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `medicos_especialidades`
--
ALTER TABLE `medicos_especialidades`
  ADD CONSTRAINT `fk_me_especialidade` FOREIGN KEY (`especialidade_id`) REFERENCES `especialidades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_me_medico` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `receitas`
--
ALTER TABLE `receitas`
  ADD CONSTRAINT `fk_receita_atendimento` FOREIGN KEY (`atendimento_id`) REFERENCES `atendimentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `receita_itens`
--
ALTER TABLE `receita_itens`
  ADD CONSTRAINT `fk_item_receita` FOREIGN KEY (`receita_id`) REFERENCES `receitas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
