\header {
  title = "Text to music"
  composer = "Mike Chernev via Python"
  tagline = "Copyright: Mike Chernev"
}\score {
\new PianoStaff << 
  \new Staff {a'4 g' <a' g'>2r2 e'4 <e' g'> a'4 a' <e' a'>2 d'4 g' a'4 g' r2 d'4 g' g'4 a' r2 <e' a'>2 r2 e'4 <e' g'> a'4 <a' c'> <e' a'>2 <a' g'>2e'4 c' d'4 g' <g' a'>4 c'' <a' g'>2a'4 a' r2 e'4 c'  r4 g' d'4 g' a'4 g' <g' a'>4 a' r2r2 <e' a'>2 a'4 g' e'4 a' r2 d'4 g' r2 d'4 g' a'4 g' e'4 c' a'4 <a' c'> a'4 g' e'4 a' r2 e'4 c' a'2 r2 <a' g'>2g'4 a' a'4 <a' c'> r2 d'4 g' e'4 c' r2 <e' a'>2 e'4 c' r2 a'4 c' a'4 <a' c'> d'4 e' <e' a'>2 a'4 g' e'4 <e' g'> <a c' e'>2}
  \new Staff { \clef bass c4 e <c g>2  a4 a4 e2 g4 e <c a>2 <c e>2 e4 c a4 a4 <c e>2 a2 a4 a4 <c a>2 a4 a4 e2 <c g>2 <c a>2 <c e g>2  g2 <c e>2 a2 <c e g>2  e4 g a4 a4 g2 r4 g <c e>2 e4 c a2 r2 a4 a4 <c a>2 e4 c e2 a4 a4 <c e>2 a4 a4 <c e>2 e4 c g2 <c g>2 e4 c e2 a4 a4 g2 <c a g>2  a4 a4 <c e g>2  a2 <c g>2 a4 a4 <c e>2 g2 a4 a4 <c a>2 g2 a4 a4 e4 a <c g>2 g2 <c a>2 c4 e a2 <c e a>2 }
>>
  \layout { }
  \midi {
    \context {
      \Staff
      \remove "Staff_performer"
    }
    \context {
      \Voice
      \consists "Staff_performer"
    }
    \tempo 2 = 72
  }
}
