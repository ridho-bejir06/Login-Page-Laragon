<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Chess vX - Fix Version</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chessboard-js/1.0.0/chessboard-1.0.0.min.css">

    <style>
        :root {
            --bg-dark: #070a13;
            --panel-bg: #111726;
            --accent-neon: #00f0ff;
            --accent-glow: rgba(0, 240, 255, 0.4);
            --text-light: #e2e8f0;
            --board-light: #dae2ea;
            --board-dark: #2b3b54;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-light);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at center, #16192b 0%, #070a13 100%);
            padding: 20px;
        }

        header {
            margin-bottom: 20px;
            text-align: center;
        }

        header h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 2.5rem;
            color: var(--accent-neon);
            text-shadow: 0 0 15px var(--accent-glow);
            letter-spacing: 3px;
        }

        header p {
            font-size: 0.9rem;
            color: #7ee7ff;
            opacity: 0.8;
        }

        .container {
            display: flex;
            flex-direction: row;
            gap: 30px;
            max-width: 1000px;
            width: 100%;
            justify-content: center;
            align-items: center;
        }

        /* Chessboard Styling */
        .board-wrapper {
            flex: 1;
            max-width: 500px;
            background: var(--panel-bg);
            padding: 15px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.6), 0 0 30px rgba(0, 240, 255, 0.1);
            border: 1px solid rgba(0, 240, 255, 0.2);
        }

        /* Custom Board Color overrides */
        .white-1e1d7 { background-color: var(--board-light) !important; }
        .black-3c85d { background-color: var(--board-dark) !important; }
        .board-b72b1 { border: 4px solid #1a2436 !important; border-radius: 8px; overflow: hidden; }

        /* Panel UI Controls */
        .panel {
            width: 320px;
            background: var(--panel-bg);
            border-radius: 16px;
            padding: 25px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 20px 40px rgba(0,0,0,0.6);
            border: 1px solid rgba(255, 255, 255, 0.05);
            height: 530px;
            justify-content: space-between;
        }

        .status-box {
            background: rgba(0, 240, 255, 0.03);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid var(--accent-neon);
        }

        .status-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.75rem;
            color: #6b7c96;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        #status {
            font-size: 1.1rem;
            font-weight: 600;
            margin-top: 5px;
            color: #fff;
        }

        #ai-thinking {
            font-size: 0.85rem;
            color: var(--accent-neon);
            margin-top: 8px;
            display: none;
        }

        .btn {
            background: linear-gradient(135deg, #00f0ff, #0072ff);
            color: #070a13;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            font-family: 'Orbitron', sans-serif;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px var(--accent-glow);
            filter: brightness(1.2);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            box-shadow: none;
        }

        /* Responsive */
        @media (max-width: 850px) {
            .container {
                flex-direction: column;
            }
            .panel {
                width: 100%;
                max-width: 500px;
                height: auto;
            }
        }
    </style>
</head>
<body>

    <header>
        <h1>CYBER CHESS vX</h1>
        <p><i class="fa-solid fa-robot"></i> Sistem AI Internal Aktif (Offline Mode)</p>
    </header>

    <div class="container">
        <div class="board-wrapper">
            <div id="myBoard" style="width: 100%"></div>
        </div>

        <div class="panel">
            <div class="status-box">
                <div class="status-title">Status Real-time</div>
                <div id="status">Giliran Kamu (Putih)</div>
                <div id="ai-thinking"><i class="fa-solid fa-microchip fa-spin"></i> AI sedang menghitung algoritma...</div>
            </div>

            <div>
                <button class="btn" id="resetBtn">
                    <i class="fa-solid fa-power-off"></i> RESTART GAME
                </button>
                <button class="btn btn-secondary" id="undoBtn">
                    <i class="fa-solid fa-backward"></i> UNDO LANGKAH
                </button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chess.js/0.10.3/chess.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chessboard-js/1.0.0/chessboard-1.0.0.min.js"></script>

    <script>
        let game = new Chess();
        let board = null;

        // --- ENGINES INTERNAL MINI-MAX (Mencegah Error CORS) ---
        // Poin evaluasi bidak catur
        const pieceValues = { p: 10, r: 50, n: 30, b: 30, q: 90, k: 9000 };

        function evaluateBoard(boardState) {
            let totalEvaluation = 0;
            for (let i = 0; i < 8; i++) {
                for (let j = 0; j < 8; j++) {
                    let piece = boardState[i][j];
                    if (piece) {
                        let value = pieceValues[piece.type];
                        totalEvaluation += (piece.color === 'w') ? value : -value;
                    }
                }
            }
            return totalEvaluation;
        }

        // Algoritma berpikir AI (Minimax dengan Alpha-Beta Pruning)
        function minimax(game, depth, alpha, beta, isMaximizingPlayer) {
            if (depth === 0 || game.game_over()) {
                return evaluateBoard(game.board());
            }

            let moves = game.moves();
            if (isMaximizingPlayer) {
                let maxEval = -Infinity;
                for (let move of moves) {
                    game.move(move);
                    let score = minimax(game, depth - 1, alpha, beta, false);
                    game.undo();
                    maxEval = Math.max(maxEval, score);
                    alpha = Math.max(alpha, score);
                    if (beta <= alpha) break;
                }
                return maxEval;
            } else {
                let minEval = Infinity;
                for (let move of moves) {
                    game.move(move);
                    let score = minimax(game, depth - 1, alpha, beta, true);
                    game.undo();
                    minEval = Math.min(minEval, score);
                    beta = Math.min(beta, score);
                    if (beta <= alpha) break;
                }
                return minEval;
            }
        }

        function getBestMove(game) {
            let moves = game.moves();
            let bestMove = null;
            let bestValue = Infinity; // AI mencari nilai terendah (Hitam)

            for (let move of moves) {
                game.move(move);
                let boardValue = minimax(game, 2, -Infinity, Infinity, true); // Depth diatur 2 agar responsif & pintar
                game.undo();
                if (boardValue <= bestValue) {
                    bestValue = boardValue;
                    bestMove = move;
                }
            }
            return bestMove;
        }

        // --- ATURAN PERMAINAN ---
        function onDragStart(source, piece, position, orientation) {
            if (game.game_over() || piece.search(/^b/) !== -1) return false;
        }

        function makeAIMove() {
            if (game.game_over()) return;

            $('#ai-thinking').fadeIn();

            setTimeout(() => {
                let aiMove = getBestMove(game);
                if (aiMove) {
                    game.move(aiMove);
                    board.position(game.fen());
                    updateStatus();
                }
                $('#ai-thinking').fadeOut();
            }, 250);
        }

        function onDrop(source, target) {
            let move = game.move({
                from: source,
                to: target,
                promotion: 'q'
            });

            if (move === null) return 'snapback';

            updateStatus();
            window.setTimeout(makeAIMove, 250);
        }

        function onSnapEnd() {
            board.position(game.fen());
        }

        function updateStatus() {
            let status = '';
            let moveColor = game.turn() === 'b' ? 'Hitam (AI)' : 'Putih (Kamu)';

            if (game.in_checkmate()) {
                status = `SKAKMAT! ${game.turn() === 'w' ? 'AI Menang!' : 'Kamu Menang!'}`;
            } else if (game.in_draw()) {
                status = 'Game Berakhir Seri (Draw)!';
            } else {
                status = `Giliran: ${moveColor}`;
                if (game.in_check()) status += ' (Sedang SKAK!)';
            }

            $('#status').text(status);
        }

        // --- KONFIGURASI PAPAN ---
        let config = {
            draggable: true,
            position: 'start',
            onDragStart: onDragStart,
            onDrop: onDrop,
            onSnapEnd: onSnapEnd,
            pieceTheme: 'https://chessboardjs.com/img/chesspieces/wikipedia/{piece}.png'
        };

        board = Chessboard('myBoard', config);
        updateStatus();

        // Tombol Aksi
        $('#resetBtn').on('click', function() {
            game.reset();
            board.start();
            updateStatus();
        });

        $('#undoBtn').on('click', function() {
            game.undo(); // Undo langkah bot
            game.undo(); // Undo langkah player
            board.position(game.fen());
            updateStatus();
        });

        $(window).resize(board.resize);
    </script>
</body>
</html>