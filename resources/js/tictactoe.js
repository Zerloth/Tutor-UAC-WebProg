import axios from "axios";

const pathArray = window.location.pathname.split("/");
const room_id = pathArray[2];
const X_CLASS = "x";
const CIRCLE_CLASS = "circle";
const WINNING_COMBINATIONS = [
    [0, 1, 2],
    [3, 4, 5],
    [6, 7, 8],
    [0, 3, 6],
    [1, 4, 7],
    [2, 5, 8],
    [0, 4, 8],
    [2, 4, 6],
];
const cellElements = document.querySelectorAll("[data-cell]");
const board = document.getElementById("board");
const winningMessageElement = document.getElementById("winningMessage");
const restartButton = document.getElementById("restartButton");
const winningMessageTextElement = document.querySelector(
    "[data-winning-message-text]"
);
let yourTurn = symbol == "x";

startGame();

restartButton.addEventListener("click", startGame);

function startGame() {
    cellElements.forEach((cell) => {
        cell.classList.remove(X_CLASS);
        cell.classList.remove(CIRCLE_CLASS);
        cell.removeEventListener("click", handleClick);
        cell.addEventListener("click", handleClick, { once: true });
    });
    setBoardHoverClass();
    winningMessageElement.classList.remove("show");
}

const channel = window.Echo.channel(`tictactoe.${room_id}`);

channel.listen(".select", (e) => {
    console.log(e);
    const currentClass = e.symbol == "o" ? CIRCLE_CLASS : X_CLASS;
    placeMark(e.cell, currentClass);
    if (checkWin(currentClass)) {
        endGame(false, e.symbol);
    } else if (isDraw()) {
        endGame(true, e.symbol);
    } else {
        setBoardHoverClass();
    }
    if (e.symbol != symbol) {
        yourTurn = true;
    }
});

async function handleClick(e) {
    if (yourTurn) {
        yourTurn = false;
        const cell = e.target.id;
        console.log(room_id, cell, symbol);
        let response = await axios.post("http://127.0.0.1:8000/turn", {
            room: room_id,
            cell: cell,
            symbol: symbol,
        });
        console.log(response);
        const currentClass = symbol == "o" ? CIRCLE_CLASS : X_CLASS;
        placeMark(cell, currentClass);
        if (checkWin(currentClass)) {
            endGame(false, symbol);
        } else if (isDraw()) {
            endGame(true, symbol);
        } else {
            setBoardHoverClass();
        }
    }
}

function endGame(draw, lastSymbol) {
    if (draw) {
        winningMessageTextElement.innerText = "Draw!";
    } else {
        winningMessageTextElement.innerText = `${lastSymbol} Wins!`;
    }
    winningMessageElement.classList.add("show");
}

function isDraw() {
    return [...cellElements].every((cell) => {
        return (
            cell.classList.contains(X_CLASS) ||
            cell.classList.contains(CIRCLE_CLASS)
        );
    });
}

function placeMark(cell, currentClass) {
    let cellBox = document.querySelector(`#${cell}`);
    cellBox.classList.add(currentClass);
}

function setBoardHoverClass() {
    board.classList.remove(X_CLASS);
    board.classList.remove(CIRCLE_CLASS);
    if (symbol == "o") {
        board.classList.add(CIRCLE_CLASS);
    } else {
        board.classList.add(X_CLASS);
    }
}

function checkWin(currentClass) {
    return WINNING_COMBINATIONS.some((combination) => {
        return combination.every((index) => {
            return cellElements[index].classList.contains(currentClass);
        });
    });
}
