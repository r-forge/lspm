/*
#
#   LSPM: The Leverage Space Portfolio Modeler
#
#   Copyright (C) 2009-2010  Soren MacBeth, Joshua Ulrich, and Ralph Vince
#
#   This program is free software: you can redistribute it and/or modify
#   it under the terms of the GNU General Public License as published by
#   the Free Software Foundation, either version 3 of the License, or
#   (at your option) any later version.
#
#   This program is distributed in the hope that it will be useful,
#   but WITHOUT ANY WARRANTY; without even the implied warranty of
#   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#   GNU General Public License for more details.
#
#   You should have received a copy of the GNU General Public License
#   along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
*/

#include <R.h>
#include <Rinternals.h>
//#include "lspm.h"

SEXP hpr ( SEXP lsp, SEXP port )
{
  /* Arguments:
   *   lsp      A 'lsp' class object
   *   port     Calculate portfolio HPR?
   */

  int P=0;
  int i, j;
  
  SEXP event = VECTOR_ELT(lsp, 0);
  SEXP prob = VECTOR_ELT(lsp, 1);
  SEXP fval = VECTOR_ELT(lsp, 2);
  SEXP maxloss = VECTOR_ELT(lsp, 3);

  // ensure lsp components are double
  if(TYPEOF(event) != REALSXP) {
    PROTECT(event = coerceVector(event, REALSXP)); P++;
  }
  if(TYPEOF(prob) != REALSXP) {
    PROTECT(prob = coerceVector(prob, REALSXP)); P++;
  }
  if(TYPEOF(fval) != REALSXP) {
    PROTECT(fval = coerceVector(fval, REALSXP)); P++;
  }
  if(TYPEOF(maxloss) != REALSXP) {
    PROTECT(maxloss = coerceVector(maxloss, REALSXP)); P++;
  }

  double *d_event = REAL(event);
  double *d_prob = REAL(prob);
  double *d_fval = REAL(fval);
  double *d_maxloss = REAL(maxloss);

  // ensure 'port' is logical
  if(TYPEOF(port) != LGLSXP) {
    PROTECT(port = coerceVector(port, LGLSXP)); P++;
  }
  int i_port = INTEGER(port)[0];

  // dimensions of events
  int nc = ncols(event);
  int nr = nrows(event);

  // if portfolio-level HPR is requested
  double hpr;
  int nc_res;
  if( i_port ) {
    nc_res = 1;
  } else {
    nc_res = nc;
  }

  SEXP result;
  PROTECT(result = allocMatrix(REALSXP, nr, nc_res)); P++;
  double *d_result = REAL(result);

  if( i_port ) {
    for(j=0; j < nr; j++) {
      hpr = 1;
      for(i=0; i < nc; i++) {
        hpr += d_fval[i] * d_event[j+i*nr] / -d_maxloss[i];
      }
      d_result[j] = hpr < 0 ? 0 : hpr;
    }
  } else {
    for(j=0; j < nr; j++) {
      for(i=0; i < nc; i++) {
        hpr = 1 + d_fval[i] * d_event[j+i*nr] / -d_maxloss[i];
        d_result[j+i*nr] = hpr < 0 ? 0 : hpr;
      }
    }
  }

  UNPROTECT(P);
  return result;
}

